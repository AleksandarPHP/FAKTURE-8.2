<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Specialist;
use App\Models\Service;
use App\Models\Client;
use Illuminate\Http\Request;
use Config;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Exception;
use Helper;

class ReservationsController extends Controller
{
    public function print($id)
    {
        $termin = Termin::with('client')->whereHas('client')->findOrFail($id);

        return view('print', ['termin' => $termin]);
    }

    public function index(Request $request)    
    {
        $request->validate([
            'date' => ['nullable', 'string', 'date_format:d/m/Y'],
            'worker' => ['nullable', 'integer', 'exists:specialists,id'],
            'service' => ['nullable', 'integer', 'exists:services,id'],
            'status' => ['nullable', 'string', 'in:0,1,2,3,4']
        ]);

        $termins = Termin::orderBy('datetime', 'desc')->orderBy('id', 'desc');

        if(!is_null($request->date)) $termins->whereDate('datetime', Carbon::createFromFormat('d/m/Y', $request->date)->toDateString());
        if(!is_null($request->worker)) $termins->where('specialist_id', $request->worker);
        if(!is_null($request->service)) $termins->whereHas('services', function($q) use ($request) {
            return $q->where('id', $request->service);
        });
        if(!is_null($request->status)) {
            switch ($request->status) {
                case '0':
                    $termins->where('datetime', '>', Carbon::now())->where('not_show_up', 0)->where('canceled', 0);
                    break;

                case '1':
                    $termins->whereRaw('datetime <= ? AND ADDTIME(`datetime`, SEC_TO_TIME(IFNULL(`minutes`, 0)*60)) >= ?', [Carbon::now(), Carbon::now()])->where('not_show_up', 0)->where('canceled', 0);
                    break;
                
                case '2':
                    $termins->whereRaw('ADDTIME(`datetime`, SEC_TO_TIME(IFNULL(`minutes`, 0)*60)) <= ?', [Carbon::now()])->where('not_show_up', 0)->where('canceled', 0);
                    break;

                case '3':
                    $termins->where('not_show_up', 1);
                    break;

                case '4':
                    $termins->where('canceled', 1);
                    break;

                default:
                    break;
            }
        }

        return view('termini', ['date' => $request->date, 'worker' => $request->worker, 'service' => $request->service, 'status' => $request->status, 'termins' => $termins->paginate(8), 'specialists' => Specialist::orderBy('first_name')->orderBy('last_name')->orderBy('id', 'desc')->get()]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'specialist' => ['nullable', 'required_with:termin,datetime', 'integer', 'exists:specialists,id'],
            'datetime' => ['nullable', 'required_with:specialist,termin', 'string', 'date_format:d/m/Y'],
            'termin' => ['nullable', 'required_with:specialist,datetime', 'integer', 'exists:termins,id'],
        ]);

        return view('rezervacija', ['datetime' => $request->datetime, 'termin' => $request->termin, 'specialist' => $request->specialist]);
    }

    public function table(Request $request)
    {
        $request->validate([
            'specialist' => ['required', 'integer', 'exists:specialists,id'],
            'datetime' => ['required', 'string', 'date_format:d/m/Y'],
        ]);

        $specialist = Specialist::with(['termins' => function($q) use ($request) {
            $q->whereDate('datetime', Carbon::createFromFormat('d/m/Y', $request->datetime));
        }])->findOrFail($request->specialist);

        $specialist->total = $specialist->termins->sum('price');
        
        return view('partials.table', ['specialist' => $specialist, 'datetime' => Carbon::createFromFormat('d/m/Y', $request->datetime)->toDateString()])->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'integer', 'exists:services,id'],
            'datetime' => ['required', 'string', 'date_format:d/m/Y'],
            'worker' => ['required', 'integer', 'exists:specialists,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'time_from' => ['required', 'string', 'date_format:H:i', Rule::in(Config::get('times_from'))],
            'time_to' => ['required', 'string', 'date_format:H:i', Rule::in(Config::get('times_to'))],
            'price' => ['required', 'numeric', 'min:0', 'max:100000'],
        ]);
            
        if(Carbon::createFromFormat('d/m/Y H:i', $request->datetime.' 23:59')->isPast()) return response()->json([
            'errors' => [['Ne možete kreirati termin sa datumom starijim od današnjeg.']]
        ], 422);

        $start = Carbon::createFromFormat('d/m/Y H:i', $request->datetime.' '.$request->time_from);
        $end = Carbon::createFromFormat('d/m/Y H:i', $request->datetime.' '.$request->time_to);

        if(Termin::with('specialist')->whereRaw('datetime < ? AND ADDTIME(`datetime`, SEC_TO_TIME(IFNULL(`minutes`, 0)*60)) > ?', [$end, $start])->whereNotNull('specialist_id')->where('specialist_id', $request->worker)->exists()) return response()->json([
            'errors' => [['Termin se preklapa sa već postojećim terminom.']]
        ], 422);

        $datetime = $start;
        $minutes = $start->diffInMinutes($end, false);

        if($minutes < 5) return response()->json([
            'errors' => [['Izabrana vremena nisu dobra.']]
        ], 422);

        $services = Service::whereIn('id', $request->services)->get();
        $specialist = Specialist::findOrFail($request->worker);
        $client = Client::findOrFail($request->client_id);

        $termin = Termin::create([
            'datetime' => $datetime->toDateTimeString(),
            'client_id' => $request->client_id,            
            'specialist_id' => $request->worker,
            'price' => $request->price,
            'servicesString' => $services->pluck('title', 'id')->toArray(),
            'minutes' => $minutes,
            'specialist_name' => $specialist->name,
            'client_name' => $client->name_without_id,
            'reminder_notification' => ($datetime->isFuture() && Carbon::now()->diffInMinutes($datetime) > 90) ? 0 : 1,
        ]);

        $termin->services()->sync($request->services);

        //SMS SENDING
        if($termin->client && !is_null($termin->client->phone) && $termin->datetime->isFuture()) {
            $sms = $this->sendSMS($termin->client->phone, $termin->datetime->format('d.m.'), $termin->datetime->format('H.i'));

            if($sms == 200) {
                return response()->json([
                    'status' => 'Sačuvano. SMS potvrda je poslata.'
                ], 200);
            }
            
            return response()->json([
                'status' => 'Sačuvano. SMS nije poslat. Provjerite broj telefona ili kredite na GatewayAPI sajtu.'
            ], 200);
        }        

        return response()->json([
            'status' => 'Sačuvano.'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $termin = Termin::findOrFail($id);

        $request->validate([
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'integer', 'exists:services,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'time_from' => ['required', 'string', 'date_format:H:i', Rule::in(Config::get('times_from'))],
            'time_to' => ['required', 'string', 'date_format:H:i', Rule::in(Config::get('times_to'))],
            'price' => ['required', 'numeric', 'min:0', 'max:100000'],
            'status' => ['nullable', 'string', 'in:not_show_up,canceled'],
        ]);                

        $start = Carbon::createFromFormat('d/m/Y H:i', $termin->datetime->format('d/m/Y').' '.$request->time_from);
        $end = Carbon::createFromFormat('d/m/Y H:i', $termin->datetime->format('d/m/Y').' '.$request->time_to);

        if(Termin::with('specialist')->whereRaw('datetime < ? AND ADDTIME(`datetime`, SEC_TO_TIME(IFNULL(`minutes`, 0)*60)) > ?', [$end, $start])->whereNotNull('specialist_id')->where('specialist_id', $termin->specialist_id)->where('id', '!=', $termin->id)->exists()) return response()->json([
            'errors' => [['Termin se preklapa sa već postojećim terminom.']]
        ], 422);

        $datetime = $start;
        $minutes = $start->diffInMinutes($end, false);

        if($minutes < 5) return response()->json([
            'errors' => [['Izabrana vremena nisu dobra.']]
        ], 422);

        $client = Client::findOrFail($request->client_id);

        $datetime = $datetime->toDateTimeString();

        $terminTimeUpdated = false;
        $terminClientUpdated = false;
        if($datetime != $termin->datetime) $terminTimeUpdated = true;
        if($request->client_id != $termin->client_id) $terminClientUpdated = true;

        $services = Service::whereIn('id', $request->services)->get();

        $termin->datetime = $datetime;
        $termin->client_id = $request->client_id;  
        $termin->client_name = $client->name_without_id;      
        $termin->minutes = $minutes;
        $termin->reminder_notification = ($termin->datetime->isFuture() && Carbon::now()->diffInMinutes($termin->datetime) > 90) ? 0 : 1;
        $termin->price = $request->price;
        $termin->servicesString = $services->pluck('title', 'id')->toArray();

        if(is_null($request->status)) {
            $termin->not_show_up = 0;
            $termin->canceled = 0;
        } else {
            $termin->not_show_up = ($request->status == "not_show_up") ? 1 : 0;
            $termin->canceled = ($request->status == "canceled") ? 1 : 0;
        }

        $termin->services()->sync($request->services);

        $termin->save();

        //SMS SENDING
        if($termin->client && !is_null($termin->client->phone) && $termin->datetime->isFuture() && ($terminTimeUpdated || $terminClientUpdated)) {
            $sms = $this->sendSMS($termin->client->phone, $termin->datetime->format('d.m.'), $termin->datetime->format('H.i'));

            if($sms == 200) {
                return response()->json([
                    'status' => 'Sačuvano. SMS potvrda je poslata.'
                ], 200);
            }

            return response()->json([
                'status' => 'Sačuvano. SMS nije poslat. Provjerite broj telefona ili kredite na GatewayAPI sajtu.'
            ], 200);
        }

        return response()->json([
            'status' => 'Sačuvano.'
        ], 200);
    }

    public function destroy($id)
    {
        $termin = Termin::findOrFail($id);    
        $termin->delete();

        return response()->json([
            'status' => 'Obrisano.'
        ], 200);
    }

    public function sendSMS($phone, $datum, $vrijeme)
    {
        try {
            $recipients = [$phone];
            $url = "https://gatewayapi.com/rest/mtsms";
            $api_token = env('GATEWAY_TOKEN', '');
            $json = [
                'message' => "Postovani,\nobavestavamo Vas da Vam je potvrdjen termin ".$datum." u ".$vrijeme."h.\nVasa \"Gala Medica\"",
                'recipients' => [],
            ];
            foreach ($recipients as $msisdn) {
                $json['recipients'][] = ['msisdn' => $msisdn];
            }

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch,CURLOPT_USERPWD, $api_token.":");
            curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($json));
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            return $httpcode;
        } catch (Exception $e) {
            return 500;
        }

        return 500;
    }
}

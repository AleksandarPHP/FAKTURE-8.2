<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Repeat_invoice;
use App\Models\Client;
use App\Models\FactureSettings;
use App\Models\Detail;
use App\Models\UserDetail;
use App\Models\MailSettings;
use Session;
use Carbon\Carbon;

class RepeatInvController extends Controller
{
    public function index(Request $request)
    {
        $invoice = Repeat_invoice::orderBy('id', 'desc');
        $totalInv = Repeat_invoice::sum('suma');
        $details = Detail::findOrFail(1);
    
        if (!is_null($request->search)) {
            $invoice->whereRaw("(client_company like ?)", ["%$request->search%", "%$request->search%"]);
        }
        if (!is_null($request->type)) {
            $invoice->whereRaw("(type like ?)", ["%$request->type%", "%$request->type%"]);
        }
        if (!is_null($request->status)) {
            $invoice->whereRaw("(status like ?)", ["%$request->status%", "%$request->status%"]);
        }
        if (!is_null($request->sort)) {
            if ($request->sort === "date") {
                $invoice->orderBy('date');
            } elseif ($request->sort === "date_of_payment") {
                $invoice->orderBy("date_of_payment");
            } elseif ($request->sort === "client_company") {
                $invoice->orderBy("client_company");
            } elseif ($request->sort === "sent") {
                $invoice->where("sent", 1);
            } elseif ($request->sort === "inv_number") {
                $invoice->orderBy('inv_number');
            }
        }
    
        if (!is_null($request->to_date)) {
            $invoice->where('date', '<=', $request->to_date);
        }
    
        if (!is_null($request->form_date)) {
            $invoice->where('date', '>=', $request->form_date);
        }
    
        return view('repeat-fakture.list', [
            'invoice' => $invoice->paginate(15),
            'search' => $request->search,
            'type' => $request->type,
            'totalInv' => $totalInv,
            'details' => $details,
            'status' => $request->status,
            'sort' => $request->sort,
            'form_date' => $request->form_date,
            'to_date' => $request->to_date,
        ]);
    }

    public function create()
    {

        $goods = Goods::orderBy('name')->orderBy('id', 'desc');
        $clients = Client::all();
        $details = Detail::all();
        $mail_settings = MailSettings::find(1);
        $facture = FactureSettings::find(1);
        $invoice = new Repeat_invoice;
        $inv = Repeat_invoice::count();
        $userDetails = UserDetail::find(1);
        $previousInvoice = Repeat_invoice::orderBy('created_at', 'desc')->first();
        if ($previousInvoice && Carbon::parse($previousInvoice->created_at)->format('Y') !== Carbon::today()->format('Y')) {
            $previousInvoice->inv_number = 0;
        }

        return view('repeat-fakture.form', ['invoice' => $invoice, 'inv' => $inv, 'goods' => $goods->paginate(8), 'mail_settings' => $mail_settings, 'clients' => $clients, 'details' => $details, 'facture' => $facture, 'previousInvoice' => $previousInvoice, 'userDetails' => $userDetails, 'editing' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lang' => ['required', 'string', 'max:191'],
            'type' => ['required', 'string', 'max:191'],
            'frequency'=> ['required', 'numeric'],
            'date_first_inv' => ['required', 'string','max:191'],
            'method_of_payment' => ['required', 'string', 'max:191'],
            'operator' => ['required', 'string', 'max:191'],
            'reference_number' => ['required', 'string', 'max:191'],
            'jir' => ['required', 'string', 'max:191'],
            'notes' => ['required', 'string', 'max:191'],
            'email_text' => ['required', 'string', 'max:191'],
            'client_individual' => ['nullable', 'numeric'],
            'client_company' => ['required', 'string', 'max:191'],
            'jib' => ['required', 'string', 'max:191'],
            'client_pdv' => ['required', 'string', 'max:191'],
            'client_address' => ['required', 'string', 'max:191'],
            'client_city' => ['required', 'string', 'max:191'],
            'client_postal_code' => ['required', 'string', 'max:191'],
            'client_email' => ['required', 'string', 'max:191'],
            'suma' => ['nullable', 'string', 'max:191'],
        ]);

        if (!Session::has('table_item') || empty(Session::get('table_item'))) {
            return redirect()->back()->withErrors(['message' => 'Za kreiranje faktue morate imati bar jednu uslugu na popisu.']);
        }

        $nowDate = Carbon::now();
        $dateNexInv = Carbon::parse($request->date_first_inv);
        $frequency = intval($request->frequency);
        if ($dateNexInv->lt($nowDate)) {
            $dateNexInv = $dateNexInv->addMonths($frequency);
        } else {
            $dateNexInv = $nowDate;
        }

        $tableItem = Session::get('table_item', []);

        $sum = 0;

        foreach($tableItem as $item){
            $sum += $item['price'] * $item['quantity'];
        }
        
        $inv = Repeat_invoice::create([
            'type' => $request->type,
            'method_of_payment' => $request->method_of_payment,
            'operator' => $request->operator,
            'frequency' => $request->frequency,
            'date_first_inv' => $request->date_first_inv,   
            'date_last_inv'=> $request->date_first_inv,
            'date_next_inv'=> $dateNexInv,
            'reference_number' => $request->reference_number,
            'jir' => $request->jir,
            'notes' => $request->notes,
            'email_text' => $request->email_text,
            'client_company' => $request->client_company,
            'jib' => $request->jib, 
            'client_pdv' => $request->client_pdv,
            'client_address' => $request->client_address,
            'client_city' => $request->client_city,
            'client_postal_code' => $request->client_postal_code,
            'client_individual' => $request->client_individual ? $request->client_individual : 0,
            'client_email' => $request->client_email,
            'suma' => $sum,
            'goods' => $tableItem,
            'lang' => $request->lang,
        ]);
    
        Session::put('table_item', []);

        session()->flash('success', 'Sačuvano.');

        return redirect('repeat-fakture');
    }

    public function edit($id)
    {
        $goods = Goods::orderBy('name')->orderBy('id', 'desc');
        $clients = Client::all();
        $details = Detail::all();
        $mail_settings = MailSettings::find(1);
        $facture = FactureSettings::find(1);
        $invoice = Repeat_invoice::findOrFail($id);
        $inv = Repeat_invoice::count();
        $userDetails = UserDetail::find(1);
        $previousInvoice = Repeat_invoice::orderBy('created_at', 'desc')->first();
        if ($previousInvoice && Carbon::parse($previousInvoice->created_at)->format('Y') !== Carbon::today()->format('Y')) {
            $previousInvoice->inv_number = 0;
        }
    
        return view('repeat-fakture.form', ['inv' => $inv, 'invoice' => $invoice, 'goods' => $goods->paginate(8), 'clients' => $clients, 'details' => $details, 'facture' => $facture, 'editing' => true]);
    }

    public function update(Request $request, $id)
    {
        $rep_inv = Repeat_invoice::findOrFail($id);

        $request->validate([
            'lang' => ['required', 'string', 'max:191'],
            'type' => ['required', 'string', 'max:191'],
            'method_of_payment' => ['required', 'string', 'max:191'],
            'date_first_inv' => ['required', 'string','max:191'],
            'operator' => ['required', 'string', 'max:191'],
            'reference_number' => ['nullable', 'string', 'max:191'],
            'jir' => ['nullable', 'string', 'max:191'],
            'notes' => ['required', 'string', 'max:191'],
            'email_text' => ['required', 'string', 'max:191'],
            'client_company' => ['required', 'string', 'max:191'],
            'jib' => ['nullable', 'string', 'max:191'],
            'client_pdv' => ['nullable', 'string', 'max:191'],
            'client_address' => ['nullable', 'string', 'max:191'],
            'client_city' => ['nullable', 'string', 'max:191'],
            'client_individual' => ['nullable', 'numeric'],
            'client_postal_code' => ['nullable', 'string', 'max:191'],
            'client_email' => ['required', 'string', 'max:191'],
            'suma' => ['nullable', 'string', 'max:191'],
        ]);

        $goods = [];
        $sum = 0; 
        for ($i = 0; $i < 10; $i++) {
            if (isset($request->name[$i])) {
                $goods[] = [
                    'name' => $request->name[$i],
                    'price' => $request->price[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_measurement' => $request->unit_measurement[$i]
                ];
                $sum += $request->price[$i] * $request->quantity[$i];
            }
        }

        $rep_inv->type = $request->type;
        $rep_inv->method_of_payment = $request->method_of_payment;
        $rep_inv->operator = $request->operator;
        $rep_inv->date_first_inv = $request->date_first_inv;
        $rep_inv->reference_number = $request->reference_number;
        $rep_inv->jir = $request->jir;
        $rep_inv->notes = $request->notes;
        $rep_inv->email_text = $request->email_text;
        $rep_inv->client_company = $request->client_company;
        $rep_inv->jib = $request->jib;
        $rep_inv->client_individual = $request->client_individual ? $request->client_individual : 0;
        $rep_inv->client_pdv = $request->client_pdv;
        $rep_inv->client_address = $request->client_address;
        $rep_inv->client_city = $request->client_city;
        // $rep_inv->client_postal_code = $request->client_postal_code;
        $rep_inv->client_email = $request->client_email;
        $rep_inv->suma = $sum;
        $rep_inv->goods = $goods;
        $rep_inv->lang = $request->lang;

        $rep_inv->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('repeat-fakture');

    }

}

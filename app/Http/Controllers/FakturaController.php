<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Categories;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\FactureSettings;
use App\Models\MailSettings;
use App\Models\Detail;
use App\Models\UserDetail;
use Pdf;
use Helper;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Log;



class FakturaController extends Controller
{
    public function index(Request $request)
    {
        $invoice = Invoice::orderBy('id', 'desc');
        $totalInv = Invoice::sum('suma');
        $neplaceno = Invoice::where('status', 0)->sum('suma');
        $placeno = Invoice::where('status', 1)->sum('suma');
        $otkazano = Invoice::where('status', 2)->sum('suma');
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
    
        return view('fakture.list', [
            'invoice' => $invoice->paginate(15),
            'search' => $request->search,
            'type' => $request->type,
            'totalInv' => $totalInv,
            'details' => $details,
            'status' => $request->status,
            'sort' => $request->sort,
            'neplaceno' => $neplaceno,
            'placeno' => $placeno,
            'otkazano' => $otkazano,
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
        $invoice = new Invoice;
        $inv = Invoice::count();
        $userDetails = UserDetail::find(1);
        $previousInvoice = Invoice::orderBy('created_at', 'desc')->first();
        if ($previousInvoice && Carbon::parse($previousInvoice->created_at)->format('Y') !== Carbon::today()->format('Y')) {
            $previousInvoice->inv_number = 0;
        }
        $previousFiscalNumber = Invoice::orderBy('fiscal_number', 'desc')->first();

        return view('fakture.form', ['invoice' => $invoice, 'inv' => $inv, 'goods' => $goods->paginate(8), 'mail_settings' => $mail_settings, 'clients' => $clients, 'details' => $details, 'facture' => $facture, 'previousInvoice' => $previousInvoice, 'previousFiscalNumber' => $previousFiscalNumber, 'userDetails' => $userDetails, 'editing' => false]);
    }

    public function store(Request $request)
    {

        dd($request->all());
        $request->validate([
            'lang' => ['required', 'string', 'max:191'],
            'type' => ['required', 'string', 'max:191'],
            'prefix' => ['nullable', 'string', 'max:191'],
            'inv_number' => ['required', 'string', 'max:191'],
            'fiscal_number' => ['nullable', 'string', 'max:191'],
            'suffix' => ['nullable', 'string', 'max:191'],
            'date' => ['required', 'string', 'max:191'],
            'time' => ['required', 'string', 'max:191'],
            'issued' => ['nullable', 'in:1'],
            'date_of_payment' => ['required', 'string', 'max:191'],
            'delivery_date' => ['required', 'string', 'max:191'],
            'method_of_payment' => ['required', 'string', 'max:191'],
            'operator' => ['required', 'string', 'max:191'],
            'reference_number' => ['nullable', 'string', 'max:191'],
            'jir' => ['required', 'numeric', 'max:191'],
            'notes' => ['required', 'string', 'max:191'],
            'email_text' => ['required', 'string', 'max:191'],
            'client_company' => ['required', 'string', 'max:191'],
            'jib' => ['nullable', 'string', 'max:191'],
            'client_pdv' => ['nullable', 'string', 'max:191'],
            'client_address' => ['nullable', 'string', 'max:191'],
            'client_city' => ['nullable', 'string', 'max:191'],
            'client_postal_code' => ['nullable', 'string', 'max:191'],
            'client_email' => ['required', 'string', 'max:191'],
            'suma' => ['nullable', 'string', 'max:191'],
        ]);

        if (!Session::has('table_item') || empty(Session::get('table_item'))) {
            return redirect()->back()->withErrors(['message' => 'Za kreiranje faktue morate imati bar jednu uslugu na popisu.']);
        }
     
        $tableItem = Session::get('table_item', []);

        $sum = 0;

        foreach($tableItem as $item){
            $sum += $item['price'] * $item['quantity'];
        }
        $currentYear = Carbon::now()->year;
        
        $inv = Invoice::create([
            'type' => $request->type,
            'prefix' => $request->prefix,
            'year' => date('Y'),
            'issued' => $request->issued,
            'inv_number' => $request->input('client_individual') == 1 ? null : $request->inv_number,
            'fiscal_number' => $request->input('client_individual') == 1 ? null : $request->fiscal_number,
            'suffix' => $request->suffix,
            'date' => $request->date,
            'time' => $request->time,
            'date_of_payment' => $request->date_of_payment,
            'delivery_date' => $request->delivery_date,
            'method_of_payment' => $request->method_of_payment,
            'operator' => $request->operator,
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
            'client_email' => $request->client_email,
            'suma' => $sum,
            'goods' => $tableItem,
            'lang' => $request->lang,
        ]);
    
        Session::put('table_item', []);

        session()->flash('success', 'Sačuvano.');

        return redirect('fakture');
    }
 
    

    public function edit(Request $request, $id)
    {
        $goods = Goods::orderBy('name')->orderBy('id', 'desc');
        $categories = Categories::orderBy('name')->orderBy('id', 'desc');
        $clients = Client::all();
        $inv = Invoice::count();
        $details = Detail::all();
        $details = Detail::all();
        $invoice = Invoice::findOrFail($id);
        $facture = FactureSettings::find(1);
    
        return view('fakture.form', ['inv' => $inv, 'invoice' => $invoice, 'goods' => $goods->paginate(8), 'categories' => $categories->paginate(8), 'clients' => $clients, 'details' => $details, 'facture' => $facture, 'editing' => true]);
    }

    public function update(Request $request, $id)
    {
        $inv = Invoice::findOrFail($id);

        $request->validate([
            'lang' => ['required', 'string', 'max:191'],
            'type' => ['required', 'string', 'max:191'],
            'prefix' => ['nullable', 'string', 'max:191'],
            'inv_number' => ['required', 'string', 'max:191'],
            'fiscal_number' => ['nullable', 'string', 'max:191'],
            'suffix' => ['nullable', 'string', 'max:191'],
            'date' => ['required', 'string', 'max:191'],
            'time' => ['required', 'string', 'max:191'],
            'date_of_payment' => ['required', 'string', 'max:191'],
            'delivery_date' => ['required', 'string', 'max:191'],
            'method_of_payment' => ['required', 'string', 'max:191'],
            'operator' => ['required', 'string', 'max:191'],
            'reference_number' => ['nullable', 'string', 'max:191'],
            'jir' => ['nullable', 'string', 'max:191'],
            'notes' => ['required', 'string', 'max:191'],
            'email_text' => ['required', 'string', 'max:191'],
            'client_company' => ['required', 'string', 'max:191'],
            'jib' => ['nullable', 'string', 'max:191'],
            'client_pdv' => ['nullable', 'string', 'max:191'],
            'client_address' => ['nullable', 'string', 'max:191'],
            'client_email' => ['required', 'string', 'max:191'],
            'client_individual' => ['nullable'],
            'suma' => ['nullable', 'string', 'max:30'],
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

        $inv->type = $request->type;
        $inv->prefix = $request->prefix;
        $inv->suffix = $request->suffix;
        $inv->inv_number = $request->inv_number;
        $inv->fiscal_number = $request->fiscal_number;
        $inv->date = $request->date;
        $inv->time = $request->time;
        $inv->date_of_payment = $request->date_of_payment;
        $inv->delivery_date = $request->delivery_date;
        $inv->method_of_payment = $request->method_of_payment;
        $inv->operator = $request->operator;
        $inv->reference_number = $request->reference_number;
        $inv->jir = $request->jir;
        $inv->notes = $request->notes;
        $inv->email_text = $request->email_text;
        $inv->client_company = $request->client_company;
        $inv->jib = $request->jib;
        $inv->client_pdv = $request->client_pdv;
        $inv->client_address = $request->client_address;
        $inv->client_city = $request->client_city;
        $inv->client_postal_code = $request->client_postal_code;
        $inv->client_email = $request->client_email;
        $inv->suma = $sum;
        $inv->goods = $goods;
        $inv->lang = $request->lang;

        $inv->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('fakture');

    }

    public function destroy($id)
    {
        $inv = Invoice::findOrFail($id);    
        $inv->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('fakture');
    }

    public function clients($id)
    {
        $clients = Client::find($id);

        return response()->json([
            'company' => $clients->first_name,
            'jib' => $clients->jmbg,
            'pdv' => $clients->pdv_id,
            'address' => $clients->address,
            'email' => $clients->email,
            'city' => $clients->city,
            'postal_code' => $clients->postal_code,
            'individual' => $clients->individual,
        ]);
    }

    public function goods($id)
    {
        $goods = Goods::find($id);

        return response()->json([
            'naziv' => $goods->name,
            'cena' => $goods->price,
            'mjerna_jedinica' => $goods->mijerna_jedinica,
            'kolicina' => $goods->kolicina,
        ]);
    }

    public function print(Request $request, $id)
    {
        $inv = Invoice::findOrFail($id);
        $userDetails = UserDetail::findOrFail(1);
        $details = Detail::findOrFail(1);
        $goods = Goods::orderBy('id', 'asc');
        $totalPrice = Goods::sum('price');

        return view('fakture.print', compact('inv', 'userDetails', 'details'), ['totalPrice' => $totalPrice, 'goods' => $goods->paginate(20)]);
    }

    public function status(Request $request, $id)
    {
        if(!is_numeric($request->status)) {
            return response()->json(['message' => 'Neispravan indeks.'], 422);
        }

        $inv = Invoice::findOrFail($id);

        $inv->status = $request->status;
        $inv->save();

        return response()->json(['success' => true]);
    }
    
    public function sendPDF(Request $request, $id)
    {
        try {
            $inv = Invoice::findOrFail($id);
            $userDetails = UserDetail::findOrFail(1);
            $details = Detail::findOrFail(1);
            $goods = Goods::orderBy('id', 'asc')->paginate(20);
            $totalPrice = Goods::sum('price');
            $goodsArray = $inv->goods;
    
            $pdf = Pdf::loadView('fakture.print', compact('inv', 'userDetails', 'details', 'goods', 'totalPrice', 'goodsArray'));
    
            $additionalText = "Hvala što ste naš klijent.";
    
            Mail::send('fakture.print', compact('inv', 'userDetails', 'details', 'goods', 'totalPrice', 'goodsArray', 'additionalText'), function ($message) use ($inv, $pdf, $additionalText) {
                $message->to($inv->client_email)
                        ->subject('Invoice PDF - '.$inv->invoice_number)
                        ->attachData($pdf->output(), 'invoice.pdf')
                        ->setBody($additionalText, 'text/plain');
            });
    
            $inv->sent = 1;
            $inv->save();
    
            session()->flash('success', 'Poslano.');
        } catch (\Exception $e) {
            Log::error($e); 
            $errorMessage = 'Došlo je do greške prilikom slanja mejla';
            return back()->withErrors([$errorMessage]);
        }
    
        return back()->with('loaderHidden', true);
    }
    
    public function copy($id)
    {
        $originalInvoice = Invoice::findOrFail($id);
        $previousInvoice = Invoice::orderBy('created_at', 'desc')->first();
        if ($previousInvoice && Carbon::parse($previousInvoice->created_at)->format('Y') !== Carbon::today()->format('Y')) {
            $previousInvoice->inv_number = 0;
        }
    
        $newInvoice = $originalInvoice->replicate();
        $newInvoice->inv_number = $previousInvoice->inv_number + 1;
        $newInvoice->status = 0;
        $newInvoice->sent = 0;
        $newInvoice->save();
    
        session()->flash('success', 'Faktura uspešno kopirana.');
    
        return redirect('fakture');
    }

    public function addToTable(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $unit_measurement = $request->input('unit_measurement');

        $itemData = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'unit_measurement' => $unit_measurement
        ]; 

        $data = Session::get('table_item', []);

        $data[] = $itemData;
        
        Session::put('table_item', $data);

        return response()->json([
            'success' => true,
            'data' => view('partials.table')->render()
        ], 200);
    }

    public function deleteRow(Request $request)
    {
        $index = $request->id; 
        if(!is_numeric($index)) {
            return response()->json(['message' => 'Neispravan indeks.'], 422);
        }
    
        $data = Session::get('table_item');
    
        if(isset($data[$index])) {
            unset($data[$index]);
            Session::put('table_item', $data);
            return response()->json(['success' => true, 'data' => view('partials.table')->render()]);
        } else {
            return response()->json(['message' => 'Element sa datim indeksom nije pronađen.'], 422);
        }
    }
}

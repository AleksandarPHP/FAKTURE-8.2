<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Exception;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('first_name')->orderBy('id', 'desc');
        return view('klijenti.list', ['clients' => $clients->paginate(20)]);
    }

    public function create()
    {
        $client = new Client;
        return view('klijenti.form', ['client' => $client, 'editing' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'naziv_firme' => ['required', 'string', 'max:255'],
            'jib' => ['nullable', 'numeric'],
            'tel' => ['nullable', 'numeric'],
            'pdv_id' => ['nullable', 'numeric'],
            'individual' => ['nullable'],
            'adresa' => ['nullable', 'string','max:191'],
            'responsible_person' => ['nullable', 'string','max:191'],
            'city' => ['nullable', 'string','max:191'],
            'postal_code' => ['nullable', 'string','max:191'],
            'email' => ['required','email', 'max:191'],
        ]);

        $clients = Client::create([
            'first_name' => $request->naziv_firme,
            'jmbg' => $request->jib,
            'tel' => $request->tel,
            'individual' => $request->individual,
            'pdv_id' => $request->pdv_id,
            'address' => $request->adresa,
            'responsible_person' => $request->responsible_person,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'email' => $request->email,
        ]);

        $clients->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('klijenti');
    }

    public function edit(Request $request, $id)
    {
        $client = Client::findOrFail($id); 
        
        return view('klijenti.form', ['client' => $client, 'editing' => true]);
    }
    
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id); 

        $request->validate([
            'naziv_firme' => ['required', 'string', 'max:30'],
            'jib' => ['nullable', 'numeric'],
            'pdv_id' => ['nullable', 'numeric'],
            'tel' => ['nullable', 'numeric'],
            'individual' => ['nullable'],
            'adresa' => ['nullable', 'string','max:191'],
            'responsible_person' => ['nullable', 'string','max:191'],
            'city' => ['nullable', 'string','max:191'],
            'postal_code' => ['nullable', 'string','max:191'],
            'email' => ['required','email', 'max:191'],
        ]);

        $client->first_name = $request->naziv_firme;
        $client->jmbg = $request->jib;
        $client->pdv_id = $request->pdv_id;
        $client->individual = $request->individual;
        $client->tel = $request->tel;
        $client->address = $request->adresa;
        $client->responsible_person = $request->responsible_person;
        $client->city = $request->city;
        $client->postal_code = $request->postal_code;
        $client->email = $request->email;

        $client->save();

        session()->flash('success', 'Sačuvano.');

         return redirect('klijenti');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);    
        $client->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('klijenti');
    }

}

<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Detail;
use App\Models\UserDetail;
use App\Models\FactureSettings;
use App\Models\MailSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class MyProfileController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'unique:users,username,'.Auth::user()->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'mimes:jpeg,png', 'image', 'max:5000', 'dimensions:min_width=180,min_height=180'],
        ]);

        $user = Auth::user();

        $time = time();
        if($request->hasFile('image')) {
            $oldFile = $user->image;
            if(!is_null($oldFile) && Storage::exists('public/users/'.$oldFile)) Storage::delete('public/users/'.$oldFile);
            if(!is_null($oldFile) && Storage::exists('public/users/res_'.$oldFile)) Storage::delete('public/users/res_'.$oldFile);

            $filename = $time.'_'.str_slug(trim($request->first_name.' '.$request->last_name)).'.'.$request->image->getClientOriginalExtension();
            $br = 2;
            while(Storage::exists('public/users/'.$filename)) {
                $filename = $time.'_'.str_slug(trim($request->first_name.' '.$request->last_name)).'-'.$br.'.'.$request->image->getClientOriginalExtension();
                $br++;
            }
                    
            $originalImage = Image::make($request->image);
            $imagePath = $request->image->storeAs('public/users', $filename);
            Storage::put('public/users/res_'.$filename, $originalImage->fit(180,180)->encode()->__toString());

            $user->image = $filename;
        } else if(!is_null($user->image) && str_slug(trim($request->first_name.' '.$request->last_name)) != str_slug($user->name)) {
            $oldFile = $user->image;

            $filename = $time.'_'.str_slug(trim($request->first_name.' '.$request->last_name)).'.'.pathinfo($oldFile, PATHINFO_EXTENSION);
            $br = 2;
            while(Storage::exists('public/users/'.$filename)) {
                $filename = $time.'_'.str_slug(trim($request->first_name.' '.$request->last_name)).'-'.$br.'.'.pathinfo(storage_path().'/public/users/'.$oldFile, PATHINFO_EXTENSION);
                $br++;
            }

            Storage::move('public/users/'.$oldFile, 'public/users/'.$filename);
            Storage::move('public/users/res_'.$oldFile, 'public/users/res_'.$filename);

            $user->image = $filename;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        if(!is_null($request->password)) $user->password = Hash::make($request->password);
        
        $user->save();
        
        session()->flash('success', 'Sačuvano.');

        return redirect('moj-profil');
    }

    public function saving(Request $request)
    {
        $userDetail = UserDetail::find(1);
    
        return view('profil.moj-profil-2', ['userDetail' => $userDetail]);
    }

    public function save_detail(Request $request)
    {
        $userDetail = UserDetail::find(1);

        $request->validate([
            'company_name' => ['required', 'string', 'max:225'],
            'telefon' => ['nullable', 'string', 'max:225'],
            'adresa' => ['nullable', 'string', 'max:30'],
            'JIB' => ['nullable', 'string', 'max:225'],
            'postal_code' => ['nullable', 'string', 'max:225'],
            'city' => ['nullable', 'string', 'max:225'],
            'image' => ['nullable', 'mimes:jpeg,png', 'image', 'max:5000', 'dimensions:min_width=180,min_height=50'],
            'PDV_ID' => ['nullable', 'string', 'int:30']
        ]);

        $time = time();
        $filename = null;
        $time = time();
        if($request->hasFile('image')) {
            $oldFile = $userDetail->image;
            if(!is_null($oldFile) && Storage::exists('public/company/'.$oldFile)) Storage::delete('public/company/'.$oldFile);
            if(!is_null($oldFile) && Storage::exists('public/company/res_'.$oldFile)) Storage::delete('public/company/res_'.$oldFile);

            $filename = $time.'_'.str_slug(trim($request->company_name)).'.'.$request->image->getClientOriginalExtension();
            $br = 2;
            while(Storage::exists('public/company/'.$filename)) {
                $filename = $time.'_'.str_slug(trim($request->company_name)).'-'.$br.'.'.$request->image->getClientOriginalExtension();
                $br++;
            }
                    
            $originalImage = Image::make($request->image);
            $imagePath = $request->image->storeAs('public/company', $filename);
            Storage::put('public/company/res_'.$filename, $originalImage->fit(180,90)->encode()->__toString());

            $userDetail->image = $filename;
        } else if(!is_null($userDetail->image) && str_slug(trim($request->company_name)) != str_slug($request->company_name)) {
            $oldFile = $userDetail->image;

            $filename = $time.'_'.str_slug(trim($request->company_name)).'.'.pathinfo($oldFile, PATHINFO_EXTENSION);
            $br = 2;
            while(Storage::exists('public/company/'.$filename)) {
                $filename = $time.'_'.str_slug(trim($request->company_name)).'-'.$br.'.'.pathinfo(storage_path().'/public/company/'.$oldFile, PATHINFO_EXTENSION);
                $br++;
            }

            Storage::move('public/company/'.$oldFile, 'public/company/'.$filename);
            Storage::move('public/company/res_'.$oldFile, 'public/company/res_'.$filename);

            $userDetail->image = $filename;
        }
    
        $userDetail->company_name = $request->company_name;
        $userDetail->telefon = $request->telefon;
        $userDetail->adresa = $request->adresa;
        $userDetail->city = $request->city;
        $userDetail->postal_code = $request->postal_code;
        $userDetail->JIB = $request->JIB;
        $userDetail -> $filename;
        $userDetail->PDV_ID = $request->PDV_ID;

        $userDetail->save();
    
        session()->flash('success', 'Sačuvano.');
        $userDetail = UserDetail::all();

        return redirect('moj-profil/2');
    }
    

    public function detail(Request $request)
    {
        $detail = Detail::find(1);

        $include_pdv = $detail->include_pdv;

        return view('profil.moj-profil-3', ['detail' => $detail, 'include_pdv' => $include_pdv]);

    }

    public function details(Request $request)
    {

        $detail = Detail::find(1);

        $request->validate([
            'bank_name'=>['required', 'string', 'max:225'],
            'bank_account'=>['nullable', 'string', 'max:225'],
            'SWIFT'=>['nullable', 'string', 'max:225'],
            'bank_acc'=>['nullable', 'string', 'max:225'],
            'alternative_payment'=>['nullable', 'string', 'max:225'],
            'alternative_payment_acc'=>['nullable', 'string', 'max:225'],
            'alternative_payment2'=>['nullable', 'string', 'max:225'],
            'alternative_payment_acc2'=>['nullable', 'string', 'max:225'],
            'PDV'=>['required', 'string', 'max:225'],
            'include_pdv'=>['nullable', 'string'],

        ]);

            switch($request->input('include_pdv')) {
                case "0": $include_pdv = 'Da'; break;
                case "1": $include_pdv = 'Ne'; break;
            }
                
        $detail->bank_name = $request->bank_name;
        $detail->bank_account = $request->bank_account;
        $detail->SWIFT = $request->SWIFT;
        $detail->bank_acc = $request->bank_acc;
        $detail->alternative_payment = $request->alternative_payment;
        $detail->alternative_payment_acc = $request->alternative_payment_acc;
        $detail->alternative_payment2 = $request->alternative_payment2;
        $detail->alternative_payment_acc2 = $request->alternative_payment_acc2;
        $detail->PDV = $request->PDV;
        $detail->include_pdv = $request->include_pdv;

        $detail->save();
  
        session()->flash('success', 'Sačuvano.');

        return redirect('moj-profil/3');
    }
    public function text(Request $request)
    {
        $texts = MailSettings::find(1);

        $payment_facture = $texts->invoice_tracking;

        return view('profil.moj-profil-4', ['texts' => $texts, 'payment_facture' => $payment_facture]);
    }

    public function texts(Request $request)
    {
        $request->validate([
            'text_email'=>['nullable', 'string', 'max:30'],
            'signature_email'=>['nullable', 'string', 'max:30'],
            'payment_facture'=>['nullable', 'string', 'max:30'],

        ]);
 
            switch($request->input('payment_facture')) {
                case "0": $payment_facture = 'Da'; break;
                case "1": $payment_facture = 'Ne'; break;
            }

        $text = MailSettings::find(1);

        $text->text = $request->text_email;
        $text->signature_in_email = $request->signature_email;
        $text->invoice_tracking = $request->payment_facture;

        $text->save();
  
        session()->flash('success', 'Sačuvano.');

        return redirect('moj-profil/4');

    }

    public function settings(Request $request)
    {
        $facture = FactureSettings::find(1);

        return view('profil.moj-profil-5', ['facture' => $facture]);
    }
    
    public function settingss(Request $request)
    {
        $request->validate([
            'limit_facture'=>['nullable', 'string', 'max:30'],
            'fee'=>['nullable', 'string', 'max:30'],
            'repet_facture'=>['nullable', 'string', 'max:30'],
            'next_repet_facture'=>['nullable', 'string', 'max:30'],
        ]);

        $facture = FactureSettings::find(1);

        $facture->limit_facture = $request->limit_facture;
        $facture->fee = $request->fee;
        $facture->repet_facture = $request->repet_facture;
        $facture->next_repet_facture = $request->next_repet_facture;
    
        $facture->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('moj-profil/5');
    }
}

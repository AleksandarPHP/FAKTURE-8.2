<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Config;

class UsersController extends Controller
{
    public function index()
    {
        return view('postavke', ['users' => User::orderBy('first_name')->orderBy('last_name')->orderBy('id', 'desc')->paginate(8)]);
    }

    public function create()
    {
        return view('radnik', ['user' => new User(), 'editing' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'is_admin' => ['required', 'string', 'in:0,1'],
            'is_active' => ['required', 'string', 'in:0,1'],            
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'mimes:jpeg,png', 'image', 'max:5000', 'dimensions:min_width=180,min_height=180'],
            'termini' => ['nullable', 'string', 'in:1'],
            'usluge' => ['nullable', 'string', 'in:1'],
            'goods' => ['nullable', 'string', 'in:1'],
            'categories' => ['nullable', 'string', 'in:1'],
            'fakture' => ['nullable', 'string', 'in:1'],
            'repeat-fakture' => ['nullable', 'string', 'in:1'],
            'klijenti' => ['nullable','string', 'in:1'],
            'pacijenti' => ['nullable', 'string', 'in:1'],
            'specijalisti' => ['nullable', 'string', 'in:1'],
            'statistika' => ['nullable', 'string', 'in:1'],
            'obavjestenja' => ['nullable', 'string', 'in:1'],
        ]);

        $time = time();
        $filename = null;
        if($request->hasFile('image')) {
            $filename = $time.'_'.str_slug(trim($request->first_name.' '.$request->last_name)).'.'.$request->image->getClientOriginalExtension();
            $br = 2;
            while(Storage::exists('public/users/'.$filename)) {
                $filename = $time.'_'.str_slug(trim($request->first_name.' '.$request->last_name)).'-'.$br.'.'.$request->image->getClientOriginalExtension();
                $br++;
            }
                    
            $originalImage = Image::make($request->image);
            $imagePath = $request->image->storeAs('public/users', $filename);
            Storage::put('public/users/res_'.$filename, $originalImage->fit(180,180)->encode()->__toString());
        }

        $user = User::create([
            'is_active' => $request->is_active,
            'is_admin' => $request->is_admin,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'image' => $filename,
            'termini' => $request->termini ? 1 : 0,
            'usluge' => $request->usluge ? 1 : 0,
            'pacijenti' => $request->pacijenti ? 1 : 0,
            'specijalisti' => $request->specijalisti ? 1 : 0,
            'statistika' => $request->statistika ? 1 : 0,
            'obavjestenja' => $request->obavjestenja ? 1 : 0,
        ]);

        session()->flash('success', 'Sačuvano.');

        return redirect('postavke/'.$user->id.'/edit');
    }

    public function edit($id)
    {
        return view('radnik', ['user' => User::findOrFail($id), 'editing' => true]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'is_admin' => ['required', 'string', 'in:0,1'],
            'is_active' => ['required', 'string', 'in:0,1'],            
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'unique:users,username,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'mimes:jpeg,png', 'image', 'max:5000', 'dimensions:min_width=180,min_height=180'],
            'termini' => ['nullable', 'string', 'in:1'],
            'usluge' => ['nullable', 'string', 'in:1'],
            'pacijenti' => ['nullable', 'string', 'in:1'],
            'specijalisti' => ['nullable', 'string', 'in:1'],
            'statistika' => ['nullable', 'string', 'in:1'],
            'obavjestenja' => ['nullable', 'string', 'in:1'],
        ]);        

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

        $user->is_active = $request->is_active;
        $user->is_admin = $request->is_admin;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        if(!is_null($request->password)) $user->password = Hash::make($request->password);

        $user->termini = $request->termini ? 1 : 0;
        $user->usluge = $request->usluge ? 1 : 0;
        $user->pacijenti = $request->pacijenti ? 1 : 0;
        $user->specijalisti = $request->specijalisti ? 1 : 0;
        $user->statistika = $request->statistika ? 1 : 0;
        $user->obavjestenja = $request->obavjestenja ? 1 : 0;
        
        $user->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('postavke/'.$user->id.'/edit');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);    
        $user->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('postavke');
    }
}

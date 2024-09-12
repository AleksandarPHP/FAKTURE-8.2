<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Helper;

class NotificationsController extends Controller
{
    public function index(Request $request)    
    {
        $request->validate([
            'search' => ['nullable', 'string'],
        ]);

        $items = Notification::orderBy('id', 'desc');

        if(!is_null($request->search)) $items->whereRaw("(title like ?)", ["%$request->search%"]);

        return view('obavjestenja', ['search' => $request->search, 'items' => $items->paginate(8)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:10000'],
            'is_active' => ['required', 'string', 'in:0,1'],
        ]);

        $item = Notification::create([            
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active
        ]);
        
        return response()->json([
            'status' => 'Sačuvano.'
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $item = Notification::findOrFail($id);

        return view('obavjestenje', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = Notification::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:10000'],
            'is_active' => ['required', 'string', 'in:0,1'],
        ]);
        
        $item->title = $request->title;
        $item->description = $request->description;
        $item->is_active = $request->is_active;
        
        $item->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('obavjestenja/'.$item->id.'/edit');
    }

    public function destroy($id)
    {
        $item = Notification::findOrFail($id);    
        $item->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('obavjestenja');
    }
}

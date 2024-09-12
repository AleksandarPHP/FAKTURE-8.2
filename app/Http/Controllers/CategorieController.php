<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use Helper;
use Carbon\Carbon;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categories::orderBy('name')->orderBy('id', 'desc');

        return view('kategorije.list', ['categories' => $categories->paginate(20)]);
    }

    public function create(Request $request)
    {
        $category = new Categories;

        return view('kategorije.form', ['category' => $category, 'editing' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
        ]);

        $categories = new Categories;
        $categories->name = $request->name;
        $categories->save();
        
        session()->flash('success', 'Sačuvano.');

        return redirect('kategorije');

    }

    public function edit(Request $request, $id)
    {
        $category = Categories::findOrFail($id);
        return view('kategorije.form', ['category' => $category, 'editing' => true]);

    }

    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:30'],
        ]);
        $category->name = $request->name;
        $category->update();
        
        session()->flash('success', 'Sačuvano.');

        return redirect('kategorije');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);    
        $category->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('kategorije');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Categories;
use Helper;
use App\Models\Detail;
use Carbon\Carbon;

class GoodsController extends Controller
{
    public function index(Request $request)    
    {
        $categories = Categories::all();
        $goods = Goods::orderBy('id', 'desc');
        
        if (!is_null($request->sort)) {
            if ($request->sort === 'name') {
                $goods = Goods::orderBy('name');
            } elseif ($request->sort === 'price') {
                $goods = Goods::orderBy('price', 'asc');
            }
        }        
        if(!is_null($request->search)) $goods->whereRaw("(name like ?)", ["%$request->search%", "%$request->search%"]);
        if (!is_null($request->categories_id)) {
            // Primeni filter samo ako je selektovana kategorija različita od 'all'
            if ($request->categories_id != 'all') {
                $goods->whereHas('categories', function ($query) use ($request) {
                    $query->where('categories_id', $request->categories_id);
                });
            }
        }
        return view('usluge.list', ['search' => $request->search, 'sort' => $request->sort, 'goods' => $goods->paginate(8), 'categories' => $categories]);
    }

    public function create(Request $request)
    {
        $categories = Categories::all();
        $goods = new Goods;

        return view('usluge.form', ['goods' => $goods, 'categories' => $categories, 'editing' => false]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'categories_id' => ['nullable', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'string', 'max: 30'],
            'pdv' => ['nullable', 'string', 'max: 30'],
            'mijerna_jedinica' => ['required', 'string', 'max:30'],
        ]);

        $goods = Goods::create([
            'name' => $request->name,
            'price' => $request->price,
            'mijerna_jedinica' => $request->mijerna_jedinica,
        ]);

        // $goods->categories()->sync($request->categories_id);

        // $goods->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('usluge');

    }

    public function edit(Request $request, $id)
    {
        $goods = Goods::findOrFail($id);
        $categories = Categories::all();

        return view('usluge.form', ['goods' => $goods, 'categories' => $categories, 'editing' => true]);

    }
    public function search(Request $request)
    {
        $sort = $request->query('sort');
    
        if ($sort === 'naziv') {
            $goods = Goods::orderBy('name')->get();
        } elseif ($sort === 'price') {
            $goods = Goods::orderBy('price', 'desc')->get();
        } else {
            $goods = Goods::all();
        }
    
        return response()->json($goods);
    }

    public function update(Request $request, $id)
    {
        $goods = Goods::findOrFail($id);

        $request->validate([
            'categories_id' => ['nullable', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'string', 'max: 30'],
            'pdv' => ['nullable', 'string', 'max: 30'],
            'mijerna_jedinica' => ['required', 'string', 'max:30'],

        ]);
        
        $goods->name = $request->name;
        $goods->price = $request->price;
        $goods->mijerna_jedinica = $request->mijerna_jedinica;

        // $goods->categories()->sync($request->categories_id);

        $goods->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('usluge');
    }

    public function destroy($id)
    {
        $goods = Goods::findOrFail($id);    
        $goods->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('usluge');
    }

    public function add(Request $request)
    {
        $request->validate([
            'categories_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'string', 'max: 30'],
            'pdv' => ['required', 'string', 'max: 30'],
            'mijerna_jedinica' => ['required', 'string', 'max:30'],

        ]);

        $goods = Goods::create([
            'name' => $request->name,
            'price' => $request->price,
            'pdv' => $request->pdv,
            'mijerna_jedinica' => $request->mijerna_jedinica,
        ]);

        $goods->categories()->sync($request->categories_id);

        $goods->save();

        session()->flash('success', 'Sačuvano.');

        return redirect('fakture/create');
    }

    public function delete($id)
    {
        $goods = Goods::findOrFail($id);    
        $goods->delete();

        session()->flash('success', 'Obrisano.');
        
        return redirect('fakture/create');
    }
}


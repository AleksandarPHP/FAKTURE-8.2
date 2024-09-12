<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('pocetna');
    }

    // public function terminsJson(Request $request)
    // {
    //     $termins = Termin::with(['client', 'specialist'])->orderBy('datetime', 'desc')->orderBy('id', 'desc')->whereDate('datetime', '>=', Carbon::now()->subMonths(2))->get();

    //     $items = [];

    //     foreach($termins as $termin)
    //         $items[] = ['title' => "\n".(count($termin->servicesString) ? implode(', ', $termin->servicesString) : '').($termin->client ? "\n".$termin->client->name : $termin->client_name).($termin->specialist ? "\n".$termin->specialist->name : $termin->specialist_name), 'start' => $termin->datetime->format('Y-m-d\TH:i:s'), 'allDay' => false, 'url' => $termin->url];

    //         return response()->json($items);
    // }
}

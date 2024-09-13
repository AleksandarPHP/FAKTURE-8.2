@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <div class="row">
             
                <div class="col-md-12 col-full-xl">
                  <h5>Pretraži fakture:</h5>
                  <form action="">
                    <div class="row">
                      <div class="col-md-2 col-full-xl">
                        <input
                            class="default_input"
                            type="text"
                            name="search"
                            id="keyword"
                            placeholder="Ključna riječ"
                            value="{{ old('search', $search) }}" @error('search') style="border-color:red;" @enderror
                        />
                      </div>
                      <div class="col-md-2 col-full-xl">
                        <select
                            class="default_select"
                            name="status"
                            id="status"
                        >
                            <option value="">Status</option>
                            <option value="0" @if($status == '0') selected @endif>Neplaćeno</option>
                            <option value="1" @if($status == '1') selected @endif>Plaćeno</option>
                            <option value="2" @if($status == '2') selected @endif>Otkazano</option>
                        </select>
                      </div>
                      <div class="col-md-2 col-full-xl">
                        <input
                            class="default_input"
                            type="date"
                            name="form_date"
                            value="{{ old('form_date', $form_date) }}"
                        />
                    </div>
                    <div class="col-md-2 col-full-xl">
                        <input
                            class="default_input"
                            type="date"
                            name="to_date"
                            value="{{ old('to_date', $to_date) }}"
                        />
                    </div>
                      <div class="col-md-2 col-full-xl">
                        <select
                            class="default_select"
                            name="type"
                            id="type"
                        >
                            <option value="">Tip</option>
                            <option value="Faktura" @if($type == 'Faktura') selected @endif>Faktura</option>
                            <option value="Predračun" @if($type == 'Predračun') selected @endif>Predračun</option>
                            <option value="Ponuda" @if($type == 'Ponuda') selected @endif>Ponuda</option>
                        </select>
                      </div>
                      <div class="col-md-2 col-full-xl">
                        <select
                            class="default_select"
                            name="sort"
                            id="sort"
                        >
                            <option value="sort" disabled selected>
                                Poredaj po
                            </option>
                            <option value="client_company" @if($sort === 'client_company') selected @endif>Naziv fabrike klijenta</option>
                            <option value="date" @if($sort == 'date') selected @endif>datum fakture</option>
                            <option value="date_of_payment" @if($sort == 'date_of_payment') selected @endif>rok plaćanja</option>
                            <option value="sent" @if($sort == 'sent') selected @endif>Poslato</option>
                            <option value="inv_number" @if($sort == 'inv_number') selected @endif>Broj fakture</option>
                        </select>
                        <div class="button-wrapper">
                          <button class="button text-end" type="submit">Traži</button>
                        </div>
                    </div>
                  </form>
                </div>

                <div class="add-new-invoice">
                  <div class="row">
                    <div class="col-xl-2 col-6">
                      <a href="{{ url('fakture/create') }}" class="add_btn">DODAJ NOVO</a>
                    </div>
                    <div class="offset-xl-4 col-xl-6">
                      <table>
                        <tbody>
                          <tr>
                            <td>Ukupno:</td><td><b>{{$totalInv}} KM</b></td>
                            <td>PDV:</td><td>{{$totalInv * ($details->PDV / 100)}} KM</td>
                            <td>Bez PDV-a:</td><td>{{$totalInv - $totalInv * ($details->PDV / 100) }} KM</td>
                          </tr>
                          <tr>
                            <td>Plaćene fakture:</td><td><b>{{$placeno}} KM</b></td>
                            <td>PDV:</td><td>{{$placeno * ($details->PDV / 100)}} KM</td>
                            <td>Bez PDV-a:</td><td>{{$placeno - $placeno * ($details->PDV / 100) }} KM</td>
                          </tr>
                          <tr>
                            <td>Neplaćene fakture:</td><td><b>{{$neplaceno}} KM</b></td>
                            <td>PDV:</td><td>{{$neplaceno * ($details->PDV / 100)}} KM</td>
                            <td>Bez PDV-a:</td><td>{{$neplaceno - $neplaceno * ($details->PDV / 100) }} KM</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <h1 class="title">FAKTURE</h1>
              </div>

                <div class="invoice-table">
                  <table width="100%" class="table-style viewManageTable"><tbody><tr>
                    <td class="table-heading">Broj fakture</td><td class="table-heading">Naziv tvrtke klijenta</td><td class="table-heading">Suma</td><td class="table-heading">Status</td><td class="table-heading">Pošalji</td><td class="table-heading">Poslano</td><td class="table-heading">Dautum kreiranja</td><td class="table-heading">Pogledaj</td>
                    <td class="table-heading">Uredi </td>
                    <td class="table-heading">Kopiraj </td>
                    <td class="table-heading">Izbriši </td>
                    </tr>
                    <!-- start -->
                    @if ($invoice->total())
                    @foreach ($invoice as $inv)
                    <tr>
                      <td style="text-align: center;"><b>{{$inv->prefix}} {{$inv->inv_number}}/{{$inv->year}} {{$inv->suffix}}</b></td>
                      <td><b style="text-transform:uppercase;"> {{$inv->client_company}}  </b></td>
                      <td><span style="white-space: nowrap;">{{ $inv->suma ?? 0}} KM</span></td>
                      <td>
                        <div class="dropdown">
                          <button @if ($inv->status == 1) style="color: #00ff3a" @elseif ($inv->status == 2) style="color: aqua" @else style="color: red" @endif class="btn btn-status dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if ($inv->status == 1) Placeno @elseif ($inv->status == 2) Otkazano @else Neplaceno @endif
                          </button>
                          <div class="dropdown-menu status-wrapper" data-inv-id="{{$inv->id}}" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item status-item" data-status-id="0">Nplaceno</button>
                            <button class="dropdown-item status-item" data-status-id="1">Placeno</button>
                            <button class="dropdown-item status-item" data-status-id="2">Otkazano</button>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <a href="{{ route('invoice.sendPDF', $inv->id) }}" class="sendInvImgSpan" style="cursor:pointer;">
                           <i class="fa fa-paper-plane" aria-hidden="true" style="color: #63cdf4;"></i>
                        </a>
                      </td>
                      <td class="text-center">
                        @if ($inv->sent == 0)
                        <i class="fa fa-times" style="color: #63cdf4;"></i>
                        @else
                        <i class="fa-regular fa-square-check" style="color: #63cdf4;"></i>
                        @endif
                      </td>
                      <td class="text-center"><span><span>{{$inv->date}}</span></span></td>
                      <td class="text-center"><a class="myNormalLink" href="@if($inv->lang == 'en'){{'en/fakture/'.$inv->id.'/print'}} @else {{'fakture/'.$inv->id.'/print'}} @endif"><i class="fa-solid fa-file" style="color: #63cdf4;"></i></a></td>
                      <td class="text-center"><a href="{{ url('fakture/'.$inv->id.'/edit') }}"><i class="fa-solid fa-pen-to-square" style="color: #63cdf4;"></i></a></td>
                      <td class="text-center">
                          <a href="{{ route('fakture.copy', $inv->id) }}">
                            <i class="fa-solid fa-copy" style="color: #63cdf4;"></i>
                          </a>
                      </td>
                      <td style="text-align: center">
                        <a href="#" class="" onclick="event.preventDefault(); if(confirm('Da li ste sigurni?')) document.getElementById('delete-form-{{ $inv->id }}').submit();">
                          <i class="fa-solid fa-trash" style="color: #63cdf4;"></i>
                        </a>
                        <form id="delete-form-{{ $inv->id }}" action="{{ url('fakture/'.$inv->id) }}" method="POST" style="display: none;">
                          @csrf
                          @method('DELETE')
                        </form>
                      </td>
                    </tr>
                    @endforeach
                    @else
                      <tr>
                        <td class="text-center" colspan="12">Nema navedenih faktura</td>
                      </tr>
                    @endif
                    <!-- end -->
                    </tbody>
                  </table>
                  {{ $invoice->links() }}

                </div>
              </div>
              <div class="col-md-12 col-full-xl"></div>
              <hr />
              <div class="row">@include('partials.app_copyright')</div>
            </div>
        </div>
        @endsection
    </div>
</div>

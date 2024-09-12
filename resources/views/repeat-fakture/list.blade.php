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
                      <a href="{{ url('repeat-fakture/create') }}" class="add_btn">DODAJ NOVO</a>
                    </div>
                    <div class="offset-xl-4 col-xl-6">
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <h1 class="title">PONAVLJAJUCE FAKTURE</h1>
              </div>

                <div class="invoice-table">
                  <table width="100%" class="table-style viewManageTable"><tbody><tr>
                    <td class="table-heading text-center">Id</td>
                    <td class="table-heading text-center">Naziv tvrtke klijenta</td>
                    <td class="table-heading text-center">Poslednje kreiranje fakture</td>
                    <td class="table-heading text-center">Uredi </td>
                    <td class="table-heading text-center">Kopiraj </td>
                    <td class="table-heading text-center">Izbriši </td>
                    </tr>
                    <!-- start -->
                    @if ($invoice->total())
                    @foreach ($invoice as $inv)
                    <tr>
                      <td class="text-center"><b> {{$inv->id}}</b></td>
                      <td class="text-center"><b style="text-transform:uppercase;"> {{$inv->client_company}}  </b></td>
                      <td class="text-center"><span><span>{{$inv->date}}</span></span></td>
                      <td class="text-center"><a href="{{ url('repeat-fakture/'.$inv->id.'/edit') }}"><i class="fa-solid fa-pen-to-square" style="color: #4a8fac;"></i></a></td>
                      <td class="text-center">
                          <a href="{{ route('fakture.copy', $inv->id) }}">
                            <i class="fa-solid fa-copy" style="color: #4a8fac;"></i>
                          </a>
                      </td>
                      <td style="text-align: center">
                        <a href="#" class="" onclick="event.preventDefault(); if(confirm('Da li ste sigurni?')) document.getElementById('delete-form-{{ $inv->id }}').submit();">
                          <i class="fa-solid fa-trash" style="color: #4a8fac;"></i>
                        </a>
                        <form id="delete-form-{{ $inv->id }}" action="{{ url('repeat-fakture/'.$inv->id) }}" method="POST" style="display: none;">
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

@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <div class="row">
                <div class="col-md-12 col-full-xl">
                  <form action="">
                    <div class="row">
                            <div class="col-md-2 col-full-xl">
                                <input
                                    class="default_input"
                                    type="text"
                                    name="search"
                                    placeholder="Ključna riječ"
                                    value="{{ old('search', $search) }}" @error('search') style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-2 col-full-xl">
                                <select
                                    class="default_select"
                                    name="sort"
                                    id="sort"
                                >
                                    <option value="" disabled selected>
                                        Poredaj po
                                    </option>
                                    <option value="name" @if($sort == 'name') selected @endif>Naziv</option>
                                    <option value="price" @if($sort == 'price') selected @endif>Cijena</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-full-xl">
                                <select
                                    class="default_select"
                                    name="categories_id"
                                    id="status"
                                >
                                    <option value="status" disabled selected>
                                      Prikaži sve
                                    </option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          <div class="col-md-2 col-full-xl">
                            <div class="button-wrapper">
                                <button class="button text-end" type="submit">Traži</button>
                              </div>
                          </div>
                        </form>
                </div>
                <div class="add-new-invoice">
                  <div class="row">
                    <div class="col-md-2">
                      <a href="{{ url('usluge/create') }}" class="add_btn">DODAJ NOVO</a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('kategorije') }}" class="add_btn">KATEGORIJE</a>
                      </div>
                  </div>
                </div>
                <div class="col-12 mt-5">
                  <h1 class="title">Usluge</h1>
              </div>
                <div class="invoice-table">
                  <table width="100%" class="table-style viewManageTable">
                    <tbody>
                      <tr>
                        <td class="table-heading" style="width:14px; display: none"><input type="checkbox" onclick="toggle(this)"></td>
                        <td class="table-heading">Naziv</td>
                        <td class="table-heading">Cijena</td>
                        <td class="table-heading">Uredi </td>
                        <td class="table-heading">Kopiraj </td>
                        <td class="table-heading">Izbriši </td>
                      </tr>
                      @if($goods->total())
                      @foreach ($goods as $item)
                      <tr>
                        <!--<td><input style="display: none" type="checkbox" name="id[]" value="{{ $item->id }}"></td>-->
                        <td><b style="text-transform:uppercase;">{{ $item->name }}</b></td>
                        <td><span style="white-space: nowrap;">{{ $item->price }} KM</span></td>
                        <td><a href="{{ url('usluge/'.$item->id.'/edit') }}"><i class="fa-solid fa-pen-to-square" style="color: #4a8fac;"></i></a></td>
                        <td><i class="fa-solid fa-copy" style="color: #4a8fac;"></i></td>
                        <td>
                          <a href="#" class="" onclick="event.preventDefault(); if(confirm('Da li ste sigurni?')) document.getElementById('delete-form-{{ $item->id }}').submit();">
                            <i class="fa-solid fa-trash" style="color: #4a8fac;"></i>
                          </a>
                          <form id="delete-form-{{ $item->id }}" action="{{ url('usluge/'.$item->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                          </form>
                        </td>
                      </tr>
                    @endforeach
                    @else
                      <tr>
                          <td class="text-center" colspan="9">Nema navedene robe</td>
                      </tr>
                    @endif
                      <!-- end -->
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="col-md-12 col-full-xl"></div>
                <hr />
                <div class="row">@include('partials.app_copyright')</div>
            </div>
        </div>
    </div>
</div>
@endsection
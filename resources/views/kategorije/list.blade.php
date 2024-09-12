@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <div class="row">
            <h1 class="title">KATEGORIJE</h1>

                <div class="col-md-12 col-full-xl">
                    <div class="add-new-invoice">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ url('kategorije/create')}}" class="add_btn">DODAJ NOVO</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-full-xl mt-5">
                    <div class="invoice-table">
                        <form>
                            <table
                                width="100%"
                                class="table-style viewManageTable"
                            >
                                <tbody>
                                    <tr>
                                        <td class="table-heading">Naziv</td>
                                        <td class="table-heading">Uredi</td>
                                        <td class="table-heading">Kopiraj</td>
                                        <td class="table-heading">Izbriši</td>
                                    </tr>
                                    @if($categories->total())
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <b
                                                style="
                                                    text-transform: uppercase;
                                                "
                                            >
                                            {{ $category->name }}
                                            </b>
                                        </td>

                                        <td>
                                            <a
                                                href="{{ url('kategorije/'.$category->id.'/edit') }}"
                                                ><i class="fa-solid fa-pen-to-square" style="color: #4a8fac;"></i></a>
                                        </td>
                                        <td>
                                            <i class="fa-solid fa-copy" style="color: #4a8fac;"></i>
                                        </td>
                                        <td>
                                            <a href="#" class="" onclick="event.preventDefault(); if(confirm('Da li ste sigurni?')) document.getElementById('delete-form-{{ $category->id }}').submit();">
                                                <i class="fa-solid fa-trash" style="color: #4a8fac;"></i>
                                              </a>
                                              <form id="delete-form-{{ $category->id }}" action="{{ url('kategorije/'.$category->id) }}" method="POST" style="display: none;">
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
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <hr />
                <div class="row">@include('partials.app_copyright')</div>
            </div>
        </div>
    </div>
</div>
@endsection
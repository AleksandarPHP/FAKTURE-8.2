
@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <h1 class="title">@if(!$editing) DODAJ USLUGU @else UREDI USLUGU @endif</h1>

            <form action="@if(!$editing) {{ url('usluge') }} @else {{ url('usluge/'.$goods->id) }} @endif" method="POST">
                @csrf
                @if($editing) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-6 col-full-xl mt-5">
                        <label for="">&nbsp;</label>
                        <select name="categories_id" id=""  class="default_select">
                            <option value="">ODABERITE KATEGORIJU</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-full-xl mt-5">
                            <label for="">
                                Naziv *
                            </label>
                            <input type="text" name="name" value="{{ old('name', $goods->name) }}" class="default_input">
                    </div>
                    <div class="col-md-6 col-full-xl">
                            <label for="">
                                Cijena *
                            </label>
                            <input type="text"  name="price" value="{{ old('price', $goods->price) }}" class="default_input">
                    </div>
                    <div class="col-md-6 col-full-xl">
                            <label for="">
                                Mjerna jedinica *
                            </label>
                            <input type="text" name="mijerna_jedinica" value="{{ old('mijerna_jedinica', $goods->mijerna_jedinica) }}" class="default_input">
                    </div>
                        <button class="button" type="submit">SPREMI</button>
                    </div>
                </div>
            </form>


                <hr />
                <div class="row">@include('partials.app_copyright')</div>
            </div>
        </div>
        @endsection
    </div>
</div>
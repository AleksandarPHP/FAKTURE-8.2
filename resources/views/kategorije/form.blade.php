@extends('partials.container')
@section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <h1 class="title">@if(!$editing) DODAJ KATEGORIJU @else UREDI KATEGORIJU @endif</h1>
            <div class="row">
                <div class="col-md-6 col-full-xl mt-5">
                    <form action="@if(!$editing) {{ url('kategorije') }} @else {{ url('kategorije/'.$category->id) }} @endif" method="POST">
                        @csrf
                        @if($editing) @method('PUT') @endif
                        <label for="">
                            Naziv*
                        </label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="default_input" required>
                        <button class="button" type="submit">SPREMI</button>
                    </form>
                </div>
                <hr />
                <div class="row">@include('partials.app_copyright')</div>
            </div>
        </div>
        @endsection
    </div>
</div>
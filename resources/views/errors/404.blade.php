@extends('partials.container')

@section('content')
<div class="container-fluid not_found">
  @include('partials.logo')
  <h1>404</h1>
  <h2>Stranica nije pronađena.</h2>
  <a href="{{ url('/') }}" class="button">Početna <i class="fas fa-angle-right"></i></a>
</div>    
@endsection
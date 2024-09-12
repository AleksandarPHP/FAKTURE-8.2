@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <h1 class="title">@if(!$editing) DODAJ KLIJENTA @else UREDI KLIJENTA @endif</h1>

            <form action="@if(!$editing) {{ url('klijenti') }} @else {{ url('klijenti/'.$client->id) }} @endif" method="POST">
            @csrf
            @if($editing) @method('PUT') @endif
            <div class="row">
                <div class="col-md-6 col-full-xl">
                       <label for="">Naziv firme:</label>
                        <input type="text" name="naziv_firme" value="{{ old('naziv_firme', $client->first_name) }}" id="naziv-firme" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                            JIB:
                        </label>
                        <input type="text" name="jib" value="{{ old('jib', $client->jmbg) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                            Broj telefona:
                        </label>
                        <input type="text" name="tel" value="{{ old('tel', $client->tel) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                    <label for="">
                        PDV-ID:
                    </label>
                    <input type="text" name="pdv_id" value="{{ old('pdv_id', $client->pdv_id) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                           Adresa:
                        </label>
                        <input type="text" name="adresa" value="{{ old('adresa', $client->address) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                           Grad:
                        </label>
                        <input type="text" name="city" value="{{ old('city', $client->city) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                           Postanski broj:
                        </label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                           Odgovorno lice:
                        </label>
                        <input type="text" name="responsible_person" value="{{ old('responsible_person', $client->responsible_person) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl">
                        <label for="">
                            E-mail:
                        </label>
                        <input type="text" name="email" value="{{ old('email', $client->email) }}" class="default_input">
                </div>
                <div class="col-md-6 col-full-xl ">
                    <label for="">
                        Fizicko lice:
                    </label>
                    <input type="checkbox" value="1" name="individual" {{ old('individual', $client->individual) ? 'checked' : '' }} class="default_input">
                </div>
                <div class="col-md-12">
                <button class="button" type="submit">SPREMI</button>
                </div>
            </form>


                <hr />
                <div class="row">@include('partials.app_copyright')</div>
            </div>
        </div>
        @endsection
    </div>
</div>
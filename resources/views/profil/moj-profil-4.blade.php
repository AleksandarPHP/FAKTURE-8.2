@extends('partials.container')
@section('content')
    @include('profil.header')
            <div
            class="tab-pane"
            id="nav-4"
            role="tabpanel"
            aria-labelledby="nav-4-tab"
        >
        <form
                action="{{ url('moj-profil-4/update') }}"
                method="post"
                enctype="multipart/form-data"
            >
            @method('PUT')
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="field_title"> Tekst e-pošte	</h5>
                                <textarea name="text_email" class="default_textarea cols="30" rows="10">{{ $texts->text }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <h5 class="field_title">  Potpis u e-poruci	</h5>
                                <textarea name="signature_email" class="default_textarea cols="30" rows="10">{{$texts->signature_in_email}}</textarea>
                            </div>

                            <div class="col-md-12">
                            <h5 class="field_title"> Praćenje faktura</h5>
                            <select name="payment_facture" class="default_select">
                                <option value="Da" @if($payment_facture == 'Da') selected @endif>Da</option>
                                <option value="Ne" @if($payment_facture == 'Ne') selected @endif>Ne</option>
                            </select>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="button">
                                    Sačuvaj
                                    <i class="fas fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

            @include('partials.app_copyright')
    @include('profil.footer')
@endsection

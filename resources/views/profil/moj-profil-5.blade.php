@extends('partials.container')
@section('content')
    @include('profil.header')
            <div
            class="tab-pane"
            id="nav-5"
            role="tabpanel"
            aria-labelledby="nav-5-tab"
        >
        <form
                action="{{ url('moj-profil-5/update') }}"
                method="post"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="field_title"> Rok za plaćanje faktura (u danima)</h5>
                                <input type="text" class="default_input"
                                required name="limit_facture" value="{{ $facture->limit_facture}}" @error('limit_facture')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">Naknada za kašnjenje</h5>
                                <input type="text" class="default_input"
                                 name="fee" value="{{ $facture->fee}}" @error('fee')
                                style="border-color:red;" @enderror>
                            </div>
                            
                            <div class="col-md-6">
                                <h5 class="field_title">Brojčani prefiks ponavljajućih faktura</h5>
                                <input type="text"
                                class="default_input" name="repet_facture" value="{{ $facture->repet_facture}}"
                                @error('repet_facture')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">Sljedeći broj ponavljajuće fakture</h5>
                                <input type="text"
                                class="default_input" name="next_repet_facture" value="{{ $facture->next_repet_facture}}"
                                @error('next_repet_facture')
                                style="border-color:red;" @enderror>
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
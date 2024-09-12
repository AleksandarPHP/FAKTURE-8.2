@extends('partials.container')
@section('content')
    @include('profil.header')
            <div
            class="tab-pane "
            id="nav-2"
        >
        <form
                action="{{ url('moj-profil/2/create') }}"
                method="post" enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <figure class="profile_image">
                                    @if($userDetail->image)
                                    <img src="{{ asset('storage/company/res_'.$userDetail->image) }}" alt="photo" class="img-fluid">
                                    @else
                                    <img src="{{ asset('assets/images/no_image.png') }}" alt="photo" class="img-fluid">
                                    @endif
                                    <br>
                                    <label class="file_input">
                                      <input type="file" name="image">
                                      <span></span>
                                      <div><i class="fas fa-edit"></i> Promijeni sliku</div>
                                    </label>
                                    <p>min. dimenzija (px): 180x180</p>
                                </figure>
                            </div>

                            <div class="col-md-6">
                                <h5 class="field_title">Naziv firme *</h5>
                                <input type="text" class="default_input"
                                 name="company_name" value="{{ old('company_name', $userDetail->company_name) }}" @error('company_name')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">Telefon</h5>
                                <input type="text" class="default_input"
                                 name="telefon" value="{{ old('telefon', $userDetail->telefon) }}" @error('telefon')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">
                                  Adresa
                                </h5>
                                <input type="text" class="default_input"
                                 name="adresa" value="{{ old('adresa', $userDetail->adresa) }}" @error('adresa')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">Grad *</h5>
                                <input type="text" class="default_input"
                                 name="city" value="{{ old('city', $userDetail->city) }}" @error('city')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">Postanski broj *</h5>
                                <input type="text" class="default_input"
                                 name="postal_code" value="{{ old('postal_code', $userDetail->postal_code) }}" @error('postal_code')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">JIB</h5>
                                <input type="text"
                                class="default_input" name="JIB" value="{{ old('JIB', $userDetail->JIB) }}"
                                @error('JIB')
                                style="border-color:red;" @enderror>
                            </div>
                            <div class="col-md-6">
                                <h5 class="field_title">
                                  PDV-ID
                                </h5>
                                <input type="text"
                                class="default_input"
                                name="PDV_ID" value="{{ old('PDV_ID', $userDetail->PDV_ID) }}"
                                @error('PDV_ID')
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

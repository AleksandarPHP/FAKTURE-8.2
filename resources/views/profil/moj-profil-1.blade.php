@extends('partials.container')
@section('content')
    @include('profil.header')
            <div class="tab-content mt-4" id="nav-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="nav-1"
                    role="tabpanel"
                    aria-labelledby="nav-1-tab"
                >
                    <form
                        action="{{ url('moj-profil') }}"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="field_title">Ime *</h5>
                                        <input type="text" class="default_input"
                                        required name="first_name" value="{{ old('first_name', Auth::user()->first_name)}}" @error('first_name')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">Prezime *</h5>
                                        <input type="text" class="default_input"
                                        required name="last_name" value="{{ old('last_name', Auth::user()->last_name)}}" @error('last_name')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">
                                            Korisničko ime *
                                        </h5>
                                        <input type="text" class="default_input"
                                        required name="username" value="{{ old('username', Auth::user()->username)}}" @error('username')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">Lozinka</h5>
                                        <input type="password"
                                        class="default_input" name="password"
                                        @error('password')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">
                                            Ponovi lozinku
                                        </h5>
                                        <input type="password"
                                        class="default_input"
                                        name="password_confirmation"
                                        @error('password_confirmation')
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
            </div>

            @include('partials.app_copyright')
    @include('profil.footer')
@endsection

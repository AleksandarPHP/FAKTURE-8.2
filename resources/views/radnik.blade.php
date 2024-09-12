@extends('partials.container')

@section('content')
<div class="container-fluid app_content">
  <div class="row">
    <div class="col app_content_left">
      @include('partials.app_nav')
    </div>
    <div class="col app_content_right">
      @include('partials.app_header')
      <div class="row">
        <div class="col-{{ $editing ? 6 : 12 }}">
          @if($editing)
          <h1 class="title">Administrator</h1>
          @else
          <h1 class="title">Novi Administrator</h1>
          @endif
        </div>
        @if($editing)
        <div class="col-6">
          <a href="#" class="delete_btn" onclick="event.preventDefault();if(confirm('Da li ste sigurni?'))document.getElementById('delete-form').submit();" class="app_header_logout">Obriši <i class="fas fa-trash-alt"></i></a>
          <form id="delete-form" action="{{ url('postavke/'.$user->id)}} " method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>
        </div>
        @endif
      </div>
      <form method="post" action="@if(!$editing) {{ url('postavke') }} @else {{ url('postavke/'.$user->id) }} @endif" enctype="multipart/form-data">
        @csrf
        @if($editing) @method('PUT') @endif
        <div class="row">
          <div class="col-md-4">
            <figure class="profile_image">
              @if($user->image)
              <img src="{{ asset('storage/users/res_'.$user->image) }}" alt="photo" class="img-fluid">
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
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <h5 class="field_title">Privilegije *</h5>
                <select class="default_select" required name="is_admin" @error('is_admin') style="border-color:red;" @enderror>
                  <option value="0" @if(old('is_admin', $user->is_admin) == 0) selected @endif>Radnik</option>
                  <option value="1" @if(old('is_admin', $user->is_admin) == 1) selected @endif>Admin (vidi sve module)</option>
                </select>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Status *</h5>
                <select class="default_select" required name="is_active" @error('is_active') style="border-color:red;" @enderror>
                  <option value="0" @if(old('is_active', $user->is_active) == 0) selected @endif>Neaktivan</option>
                  <option value="1" @if(old('is_active', $user->is_active) == 1) selected @endif>Aktivan</option>                  
                </select>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Ime *</h5>
                <input type="text" class="default_input" required name="first_name" value="{{ old('first_name', $user->first_name) }}" @error('first_name') style="border-color:red;" @enderror>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Prezime *</h5>
                <input type="text" class="default_input" required name="last_name" value="{{ old('last_name', $user->last_name) }}" @error('last_name') style="border-color:red;" @enderror>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Korisničko ime *</h5>
                <input type="text" class="default_input" required name="username" value="{{ old('username', $user->username) }}" @error('username') style="border-color:red;" @enderror>
              </div>
              <div class="col-md-6"></div>
              <div class="col-md-6">
                <h5 class="field_title">Lozinka @if(!$editing)*@endif</h5>
                <input type="password" class="default_input" @if(!$editing) required @endif name="password" @error('password') style="border-color:red;" @enderror>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Ponovi lozinku @if(!$editing)*@endif</h5>
                <input type="password" class="default_input" @if(!$editing) required @endif name="password_confirmation" @error('password_confirmation') style="border-color:red;" @enderror>
              </div>
              <div class="col-12">
                <button type="submit" class="button">Sačuvaj <i class="fas fa-angle-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </form>
      @include('partials.app_copyright')
    </div>
  </div>
</div>
@endsection
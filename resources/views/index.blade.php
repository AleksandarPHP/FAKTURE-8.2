@extends('partials.container')

@section('content')
<div class="container-fluid app_login">
  <div class="app_login_form">
    @include('partials.logo')
    @include('partials.messages')
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <label class="app_login_input">
        <span><i class="fas fa-user"></i></span>
        <input type="text" @error('username') style="border-color:red;" @enderror name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Korisničko ime *">
      </label>
      <label class="app_login_input">
        <span><i class="fas fa-unlock"></i></span>
        <input type="password" @error('password') style="border-color:red;" @enderror name="password" required autocomplete="current-password" placeholder="Lozinka *">
      </label>
      <label class="default_checkbox">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}><span></span> Zapamti me
      </label>
      <button type="submit" class="button">Login <i class="fas fa-angle-right"></i></button>
    </form>
  </div>
</div>
@endsection
<header class="row app_header">
  <div class="col-md-5">
    <div class="app_header_time">
      <i class="far fa-clock"></i>
      <span id="date-time"></span>
    </div>
  </div>
  <div class="col-md-7 text-right">
    <a href="{{ url('/') }}" class="app_header_home">
      <i class="fas fa-home"></i>
    </a>
    <a href="{{ url('moj-profil') }}" class="app_header_user">
      @if(Auth::user()->image)
      <img src="{{ asset('storage/users/res_'.Auth::user()->image) }}" alt="photo">
      @else
      <img src="{{ asset('assets/images/no_image.png') }}" alt="photo">
      @endif
      <span>{{ Auth::user()->name }}</span>
    </a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="app_header_logout">
      <img src="{{ asset('assets/images/logout.svg') }}" alt="logout">
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
    <button class="app_header_menu">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</header>
@include('partials.messages')
<div class="FormSuccessMessageGlobal" style="display:none;">
  <div class="alert alert-success">
    <strong>Uspjeh!</strong><br>
    <div class="message"></div>
  </div>
</div>
<aside class="app_nav">
  <button class="app_nav_close"><i class="fas fa-times"></i></button>
  @include('partials.logo')
  <nav>
    <ul>
      <li @if(request()->is('/'))class="active"@endif>
        <a href="{{ url('/') }}"><i class="fas fa-home"></i> Početna</a>
      </li>
      <!--@if(Auth::user()->termini || Auth::user()->is_admin)-->
      <!--<li @if(request()->is('rezervacija'))class="active"@endif>-->
      <!--  <a href="{{ url('rezervacija') }}"><i class="far fa-calendar-plus"></i> Rezervacija</a>-->
      <!--</li>-->
      <!--<li @if(request()->is('termini*'))class="active"@endif>-->
      <!--  <a href="{{ url('termini') }}"><i class="fas fa-calendar-alt"></i> Termini</a>-->
      <!--</li>-->
      <!--@endif-->
      {{-- @if(Auth::user()->usluge || Auth::user()->is_admin)
      <li @if(request()->is('usluge*'))class="active"@endif>
        <a href="{{ url('usluge') }}"><i class="fas fa-wrench"></i> Usluge</a>
      </li>
      @endif --}}
      @if(Auth::user()->fakture || Auth::user()->is_admin)
      <li @if(request()->is('fakture*'))class="active"@endif>
        <a href="{{ url('fakture') }}"><i class="fas fa-file-invoice"></i> Fakture</a>
      </li>
      @endif
            @if(Auth::user()->klijenti || Auth::user()->is_admin)
      <li @if(request()->is('klijenti*'))class="active"@endif>
        <a href="{{ url('klijenti') }}"><i class="fas fa-users"></i> Klijenti</a>
      </li>
      @endif
      <!--@if(Auth::user()->specijalisti || Auth::user()->is_admin)-->
      <!--<li @if(request()->is('specijalisti*'))class="active"@endif>-->
      <!--  <a href="{{ url('specijalisti') }}"><i class="fas fa-stethoscope"></i> Specijalisti</a>-->
      <!--</li>-->
      <!--@endif-->
      <!--@if(Auth::user()->statistika || Auth::user()->is_admin)-->
      <!--<li @if(request()->is('statistika*'))class="active"@endif>-->
      <!--  <a href="{{ url('statistika') }}"><i class="fas fa-chart-bar"></i> Statistika</a>-->
      <!--</li>-->
      <!--@endif-->
      {{-- @if(Auth::user()->obavjestenja || Auth::user()->is_admin)
      <li @if(request()->is('obavjestenja*'))class="active"@endif>
        <a href="{{ url('obavjestenja') }}"><i class="fas fa-envelope"></i> Obavještenja</a>
      </li>
      @endif --}}
      @if(Auth::user()->obavjestenja || Auth::user()->is_admin)
      <li @if(request()->is('usluge*'))class="active"@endif>
        <a href="{{ url('usluge') }}"><i class="fas fa-chart-bar"></i> Usluge</a>
      </li>
      @endif
      @if(Auth::user()->repeat_fakture || Auth::user()->is_admin)
      <li @if(request()->is('repeat-fakture*'))class="active"@endif>
        <a href="{{ url('repeat-fakture') }}"><i class="fas fa-file-invoice"></i>Ponavljajuca fakture</a>
      </li>
      @endif
      @if(Auth::user()->is_admin)
      <li @if(request()->is('postavke*'))class="active"@endif>
        <a href="{{ url('postavke') }}"><i class="fas fa-cog"></i> Postavke</a>
      </li>
      @endif
      <li @if(request()->is('moj-profil'))class="active"@endif>
        <a href="{{ url('moj-profil') }}"><i class="fas fa-user-circle"></i> Moj profil</a>
      </li>
    </ul>
  </nav>
</aside>
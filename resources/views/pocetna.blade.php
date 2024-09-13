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
        <div class="col-12">
          <h1 class="title">Početna</h1>
        </div>
      </div>
      <div class="row">
                  <div class="col-md-4">
          <a href="{{ url('/') }}" class="link_box">
            <i class="fa-solid fa-house fa-2xl" style="color: #63cdf4;"></i>
            <h2>Početna</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>        <div class="col-md-4">
          <a href="{{ url('fakture') }}" class="link_box">
            <i class="fa-solid fa-file fa-2xl" style="color: #63cdf4;"></i>
            <h2>Fakture</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>        <div class="col-md-4">
          <a href="{{ url('klijenti') }}" class="link_box">
            <i class="fa-solid fa-people-group fa-2xl" style="color: #63cdf4;"></i>
            <h2>Klijenti</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>        <div class="col-md-4">
          <a href="{{ url('usluge') }}" class="link_box">
           <i class="fa-solid fa-chart-column fa-2xl" style="color: #63cdf4;"></i>
            <h2>Usluge</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>        <div class="col-md-4">
          <a href="{{ url('repeat-fakture') }}" class="link_box">
            <i class="fa-solid fa-repeat fa-2xl" style="color: #63cdf4;"></i>
            <h2>Ponavljajuća faktura</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>        <div class="col-md-4">
          <a href="{{ url('postavke') }}" class="link_box">
            <i class="fa-solid fa-gear fa-2xl" style="color: #63cdf4;"></i>
            <h2>Postavke</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <!--@if(Auth::user()->termin || Auth::user()->is_admin)-->
        <div class="col-md-4">
          <a href="{{ url('moj-profil') }}" class="link_box">
            <i class="fa-solid fa-user fa-2xl" style="color: #63cdf4;"></i>
            <h2>Moj profil</h2>
            <span><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <!--@endif-->
      @include('partials.app_copyright')
    </div>
  </div>
</div>
@endsection

@section('scripts')
@if(Auth::user()->termin || Auth::user()->is_admin)
<script type="text/javascript">
// calendar
$(window).on('load', function() {
  if ($('#calendar').length) {  
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'sr-ME',
      height: 'auto',
      plugins: [ 'dayGrid' ],
      views: {
        dayGrid: {
          eventLimit: 3,
        }
      },
      events: '{{ url('termini-json') }}',
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: false
      },
      eventClick: function(info) {
        info.jsEvent.preventDefault();
    
        if (info.event.url) {
          window.open(info.event.url, '_self');
        }
      }
    });

    calendar.render();
  }
});
</script>
@endif
@endsection
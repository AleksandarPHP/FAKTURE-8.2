<form action="{{ url()->current() }}" method="get" id="filter-form">
  <div class="row filters">
    <div class="col">
      <h5>Datum</h5>
      <div class="default_datepicker">
        <input type="text" class="default_input datepicker-input" autocomplete="off" placeholder="DD/MM/JJJJ" name="date" value="{{ old('date', $date) }}" @error('date') style="border-color:red;" @enderror>
      </div>
    </div>
    @if(!request()->is('specijalisti*'))
    <div class="col">
      <h5>Specijalista</h5>
      <select class="default_select" name="worker" @error('worker') style="border-color:red;" @enderror>
        <option value="">Prikaži sve</option>
        @foreach ($specialists as $specialist)
        <option value="{{ $specialist->id }}" @if(old('worker', $worker) == $specialist->id) selected @endif>{{ $specialist->name }}</option>    
        @endforeach
      </select>
    </div>
    @endif
    <div class="col">
      <h5>Usluga</h5>
      <div class="services_select_wrap mb-3">
        <select id="services_select_filter" class="default_select" name="service" data-id="{{ old('service', $service) }}">
          <option value="">Prikaži sve</option>
        </select>
      </div>
    </div>
    <div class="col">
      <h5>Status</h5>
      <select class="default_select" name="status" @error('status') style="border-color:red;" @enderror>
        <option value="">Prikaži sve</option>
        <option value="0" @if(old('status', $status) == "0") selected @endif>Na čekanju</option>
        <option value="1" @if(old('status', $status) == "1") selected @endif>U toku</option>
        <option value="2" @if(old('status', $status) == "2") selected @endif>Završeno</option>
        <option value="3" @if(old('status', $status) == "3") selected @endif>Nije se pojavio</option>
        <option value="4" @if(old('status', $status) == "4") selected @endif>Otkazao</option>
      </select>
    </div>
    <div class="col">
      <div class="row">
        <div class="col-md-6">
          <button type="submit" class="button">Filtriraj</button>
        </div>
        <div class="col-md-6">
          <a href="{{ str_replace('edit' , 'print', url()->full()) }}" class="button" target="_blank">Štampaj</a>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="termins">
  @if(count($termins) == 0)
  <h6>Nema nijedan termin za prikazivanje.</h6>
  @endif
  @foreach ($termins as $termin)
  <div class="termin row">
    <div class="col termin_title">
      <div>
        <img src="{{ asset('assets/images/termin_client.png') }}" alt="termin_client">
        <h4>{{ $termin->client ? $termin->client->name : $termin->client_name }}</h4>
        <p>{{ $termin->price }} KM / {{ count($termin->servicesString) ? implode(', ', $termin->servicesString) : '' }}</p>
      </div>
    </div>
    <div class="col termin_field">
      <span><i class="far fa-clock"></i> <b>{{ $termin->datetime->format('H:i') }}</b> - {{ $termin->datetime->format('d/m/Y') }}</span>
    </div>
    <div class="col termin_field">
      <span><i class="fas fa-stethoscope"></i> {{ ($termin->specialist) ? $termin->specialist->name : $termin->specialist_name }}</span>
    </div>
    @if($termin->status)
    <div class="col termin_status">
      <span class="canceled">{{ $termin->status }}</span>
    </div>
    @elseif(Carbon\Carbon::now()->between($termin->datetime, $termin->datetime->addMinutes($termin->minutes)))
    <div class="col termin_status">
      <span class="active">U toku</span>
    </div>
    @elseif($termin->datetime->isPast())
    <div class="col termin_status">
      <span class="finished">Završeno</span>
    </div>          
    @else
    <div class="col termin_status">
      <span class="waiting">Na čekanju</span>
    </div>
    @endif
    <div class="termin_options">
      @if($termin->print_url)
      <a href="{{ $termin->print_url }}" class="termin_options_print" target="_blank">
        <i class="fas fa-print"></i>
      </a>
      @endif
      @if($termin->url)
      <a href="{{ $termin->url }}"><i class="fas fa-edit"></i></a>
      @endif
    </div>
  </div>
  @endforeach
</div>
@if($termins->hasPages())
{{ $termins->links() }}
@endif
<div class="col-12">
  <div class="statistic row">
    <div class="statistic_box gold col-lg-5">
      <h3>Prihod</h3>
      <h4>{{ number_format($sum ?? 0, 0, '.', '\'') }} KM <span><img src="{{ asset('assets/images/cash.svg') }}" alt="cash"></span></h4>
    </div>
    <div class="statistic_box gold col-lg-5 offset-lg-1">
      <h3>Termini</h3>
      <h4>{{ number_format($termins->total() ?? 0, 0, '.', '\'') }} <span><img src="{{ asset('assets/images/service.svg') }}" alt="service"></span></h4>
    </div>
  </div>
</div>
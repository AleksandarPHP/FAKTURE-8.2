@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <form action="@if(!$editing) {{ route('repeat-fakture.store') }} @else {{ url('repeat-fakture/'.$invoice->id) }} @endif" method="POST">
                @csrf
                @if($editing) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-5 col-full-xl">
                        <div class="col-md-12 col-full-xl">
                            <h6>Izaberite jezik fakture:</h6>
                            <div class="d-flex change-language" style="justify-content: space-around">
                                <div>
                                    <label for="lang-sr">SR:</label>
                                    <input type="checkbox" name="lang" id="lang-sr" value="sr" class="default_input lang-checkbox" {{ (old('lang', $invoice->lang) == 'sr') ? 'checked' : '' }}>
                                </div>
                                <div>
                                    <label for="lang-en">EN:</label>
                                    <input type="checkbox" name="lang" id="lang-en" value="en" class="default_input lang-checkbox" {{ (old('lang', $invoice->lang) == 'en') ? 'checked' : '' }}>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="type">Tip:</label>
                            <select name="type" id="type" class="default_select">
                                <option value="Faktura" @if(old('type', $invoice->type) == 'Faktura') selected @endif>Faktura</option>
                                <option value="Predračun" @if(old('type', $invoice->type) == 'Predračun') selected @endif>Predračun</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="frequency">Ucestalost:</label>
                            <select name="frequency" id="frequency" class="default_select">
                                <option value="1" @if(old('frequency', $invoice->frequency) == '1') selected @endif>Mjesecno</option>
                                <option value="3" @if(old('frequency', $invoice->frequency) == '3') selected @endif>Kvartalno</option>
                                <option value="12" @if(old('frequency', $invoice->frequency) == '12') selected @endif>Godisnje</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="date_first_inv">Prva Faktura:</label>
                            <input class="default_input" type="date" name="date_first_inv" id="date_first_inv" value="{{ old('date_first_inv', $invoice->date_first_inv) }}" />
                        </div>
                        @if ($editing)
                        <div class="col-md-12 col-full-xl">
                            <label for="date_last_inv">Zadnja Faktura:</label>
                            <input class="default_input" type="date" name="date_last_inv" id="date_last_inv" value="{{ old('date_last_inv', $invoice->date_last_inv) }}" />
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="date_next_inv">Sledeca Faktura:</label>
                            <input class="default_input" type="date" name="date_next_inv" id="date_next_inv" value="{{ old('date_next_inv', $invoice->date_next_inv) }}" />
                        </div>
                        @endif
                        <div class="col-md-12 col-full-xl">
                            <label for="">Da li je racun izdat kompjuterski:</label>
                            <input class="default_input" type="checkbox" {{ old('issued', $invoice->issued) ? 'checked' : '' }}  name="issued" value="1" />
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Način plaćanja:</label>
                            <select name="method_of_payment" id="" class="default_select">
                                <option value="Transakcijski račun">Transakcijski račun</option>
                                <option value="Kartica">Kartica</option>
                                <option value="Ček">Ček</option>
                                <option value="Ostalo">Ostalo</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Operater / Fakturu izdao:</label>
                            <input class="default_input" type="text" name="operator" value="@if (!$editing){{ old('operator', Auth::user()->name)}} @else {{old('operator',$invoice->operator)}} @endif"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Model / Poziv na broj:</label>
                            <input class="default_input" type="text" name="reference_number" value="{{old('reference_number', $invoice->reference_number)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">JIR i ZKI:</label>
                            <input class="default_input" type="text" name="jir" value="{{old('jir', $invoice->jir)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Napomene:</label>
                            <textarea
                                class="default_textarea"
                                id=""
                                cols="30"
                                rows="5"
                                name="notes"
                            >{{ old('notes', $invoice->notes)}}</textarea>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Tekst maila:</label>
                            <textarea
                                class="default_textarea"
                                name="email_text"
                                id=""
                                cols="30"
                                rows="5"
                            >@if(!$editing){{ old('notes', $mail_settings->text)}} @else {{ old('notes', $invoice->notes) }} @endif</textarea>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <h2 style="color: #4a8fac"><b>LISTA KLIJENATA</b></h2>
                            <select name="lista_klijenata" class="default_select" data-live-search="true" id="lista_klijenata">
                                <option value="----">----</option>
                                @if($clients->count() > 0)
                                @foreach ($clients as $client)
                                <option data-tokens="{{ $client->first_name }}" value="{{ $client->id }}">{{ $client->first_name }}</option>
                                @endforeach
                                @else
                                <option value="----">----</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Naziv firme klijenta:</label>
                            <input type="text" class="default_input" name="client_company" id="client_company" value="{{old('client_company', $invoice->client_company)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">JIB klijenta:</label>
                            <input type="text" class="default_input" name="jib" id="jib" value="{{old('jib', $invoice->jib)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">PDV-ID klijenta:</label>
                            <input type="text" class="default_input" name="client_pdv" id="client_pdv" value="{{old('client_pdv', $invoice->client_pdv)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Adresa firme klijenta:</label>
                            <input type="text" class="default_input" name="client_adderss" id="client_address" value="{{old('client_address', $invoice->client_adderss)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Grad klijenta:</label>
                            <input type="text" class="default_input" name="client_city" id="client_city" value="{{old('client_city', $invoice->client_city )}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Postanski kod klijenta:</label>
                            <input type="text" class="default_input" name="client_postal_code" id="client_postal_code" value="{{old('client_postal_code', $invoice->client_postal_code)}}"/>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">E-mail klijenta</label>
                            <input type="email" class="default_input" name="client_email" id="client_email" value="{{old('client_email', $invoice->client_email)}}"/>
                        </div>
                        <input type="hidden" class="default_input" name="client_individual" id="client_individual" value="{{old('client_individual', $invoice->client_individual)}}"/>
                    </div>
                    <div class="col-md-7 col-full-xl ">
                        <h2 style="color:#4a8fac;"><b>POPIS USLUGA</b></h2>
                        <div class="col-md-12 col-full-xl px-0">
                            @if (!$editing)
                                @include('partials.table')
                            @else
                                @include('partials.row-list')
                            @endif
                            <hr >
                            @if (!$editing)
                                @include('partials.add-services')
                            @endif
                            <div class="row mt-5">
                                <div class="col-md-3">
                                    <button class="add_btn">SPREMI</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr />
            <div class="row">@include('partials.app_copyright')</div>
        </div>
    </div>
</div>
@endsection
@section('variables')
<script type="text/javascript">    
    document.addEventListener('DOMContentLoaded', function() {
        let listaRobe = document.getElementById('lista_robe');
        let nazivInput = document.getElementById('naziv');
        let cenaInput = document.getElementById('cena');
        let kolicinaInput = document.getElementById('kolicina');
        let mjernaJedinicaInput = document.getElementById('mjerna_jedinica');

        listaRobe.addEventListener('change', function() {
            let goodsId = this.value;

            let url = '/api/goods/' + goodsId;

            fetch(url)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    nazivInput.value = data.naziv;
                    cenaInput.value = data.cena;
                    kolicinaInput.value = data.kolicina;
                    mjernaJedinicaInput.value = data.mjerna_jedinica;
                })
                .catch(function(error) {
                    console.log('Došlo je do greške:', error);
                });
        });
    });
</script>
@endsection
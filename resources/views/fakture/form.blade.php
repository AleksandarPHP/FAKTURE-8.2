@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <form action="@if(!$editing) {{ route('fakture.store') }} @else {{ url('fakture/'.$invoice->id) }} @endif" method="POST">
                @csrf
                @if($editing) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-5 col-full-xl">
                        <div class="col-md-12 col-full-xl">
                            <h2>PRETHODNA FAKTURA, BROJ: <span>{{ $previousInvoice->inv_number ?? 0 }}</span></h2>
                        </div>
                        <br>
                        <br>
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
                                <option value="Ponuda" @if(old('type', $invoice->type) == 'Ponuda') selected @endif>Ponuda</option>
                                <option value="Knjižno_odobrenje" @if(old('type', $invoice->type) == 'Knjižno_odobrenje') selected @endif>Knjižno odobrenje</option>
                                <option value="Knjižno_zaduženje" @if(old('type', $invoice->type) == 'Knjižno_zaduženje') selected @endif>Knjižno zaduženje</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Broj fakture:</label>
                            <div class="row">
                                <div class="col-md-4 col-full-xl">
                                    <input
                                        class="default_input"
                                        type="text"
                                        placeholder="Prefiks"
                                        name="prefix"
                                        value="{{old('prefix', $invoice->prefix)}}"
                                    />
                                </div>
                                <div class="col-md-4 col-full-xl">
                                    <input
                                        class="default_input"
                                        type="text"
                                        name="inv_number"
                                        value="@if (!$editing){{ old('inv_number', isset($previousInvoice) ? $previousInvoice->inv_number + 1 : 1 )}} @else {{ old('inv_number', $invoice->inv_number) }} @endif"/>
                                </div>
                                <div class="col-md-4 col-full-xl">
                                    <input
                                        class="default_input"
                                        type="text"
                                        placeholder="Sufiks"
                                        name="suffix"
                                        value="{{old('suffix', $invoice->suffix)}}"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Broj fiskalnog racuna:</label>
                            <div class="row">
                                <div class="col-md-4 col-full-xl">
                                    <input
                                        class="default_input"
                                        type="text"
                                        name="fiscal_number"
                                        value="{{ isset($previousFiscalNumber) ? $previousFiscalNumber->fiscal_number + 1 : 1 }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Da li je racun izdat kompjuterski:</label>
                            <input class="default_input" type="checkbox" {{ old('issued', $invoice->issued) ? 'checked' : '' }}  name="issued" value="1" />
                        </div>
                            
                        <input class="brojDana" type="number" id="brojDana" value="{{ $facture->limit_facture }}">
                        <div class="col-md-12 col-full-xl">
                            <label for="">Datum fakture:</label>
                            <input class="default_input" type="date" name="date" id="dateInput" value="{{ old('date', $invoice->date) }}" />
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Vrijeme izdavanja:</label>
                            <input class="default_input" type="time" name="time" id="timeInput" value="{{ old('time', $invoice->time) }}" />
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Rok plaćanja:</label>
                            <input class="default_input" type="date" name="date_of_payment" id="datum" value="{{old('date_of_payment', $invoice->date_of_payment)}}">
                        </div>
                        <div class="col-md-12 col-full-xl">
                            <label for="">Datum isporuke:</label>
                            <input class="default_input" type="date" name="delivery_date" id="delivery_date" value="{{old('delivery_date', $invoice->delivery_date)}}"/>
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
                            <h2 style="color: #63cdf4"><b>LISTA KLIJENATA</b></h2>
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
                            <input type="text" class="default_input" name="client_address" id="client_address" value="{{old('client_address', $invoice->client_address)}}"/>
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
                        <h2 style="color:#63cdf4;"><b>POPIS USLUGA</b></h2>
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
        let brojDanaInput = document.getElementById('brojDana');
        let datumInput = document.getElementById('datum');

        brojDanaInput.addEventListener('input', function() {
        let brojDana = parseInt(this.value);
        if (!isNaN(brojDana)) {
        let danas = new Date(); 
        let buduciDatum = new Date(danas.getFullYear(), danas.getMonth(), danas.getDate() + brojDana);

        let godina = buduciDatum.getFullYear();
        let mesec = (buduciDatum.getMonth() + 1).toString().padStart(2, '0'); 
        let dan = buduciDatum.getDate().toString().padStart(2, '0'); 

        let formatiraniDatum = godina + '-' + mesec + '-' + dan; 

        datumInput.value = formatiraniDatum; 
            }
        });

        brojDanaInput.dispatchEvent(new Event('input'));
    });

    function setCurrentDateTime() {
        const currentDateTime = new Date();
        const year = currentDateTime.getFullYear();
        const month = String(currentDateTime.getMonth() + 1).padStart(2, "0");
        const day = String(currentDateTime.getDate()).padStart(2, "0");
        const hours = String(currentDateTime.getHours()).padStart(2, "0");
        const minutes = String(currentDateTime.getMinutes()).padStart(2, "0");

        const currentDateString = `${year}-${month}-${day}`;
        const currentTimeString = `${hours}:${minutes}`;

        document.getElementById("dateInput").value = currentDateString;
        // document.getElementById("timeInput").value = currentTimeString;
        document.getElementById("delivery_date").value = currentDateString;
    }

    window.onload = setCurrentDateTime;

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
@extends('partials.container')
@section('content')
    @include('profil.header')
           <div
                    class="tab-pane"
                    id="nav-3"
                    role="tabpanel"
                    aria-labelledby="nav-3-tab"
                >
                <form
                        action="{{ url('moj-profil-3/update') }}"
                        method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="field_title">Naziv banke </h5>
                                        <input type="text" class="default_input"
                                         name="bank_name" value="{{ old('bank_name', $detail->bank_name) }}" @error('bank_name')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title"> Bankovni račun (IBAN)</h5>
                                        <input type="text" class="default_input"
                                         name="bank_account" value="{{ old('bank_account', $detail->bank_account) }}" @error('bank_account')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">
                                        SWIFT/BIC
                                        </h5>
                                        <input type="text" class="default_input"
                                         name="SWIFT" value="{{ old('SWIFT', $detail->SWIFT) }}" @error('SWIFT')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">Ziro Racun </h5>
                                        <input type="text" class="default_input"
                                         name="bank_acc" value="{{ old('bank_acc', $detail->bank_acc) }}" @error('bank_acc')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title"> Alternativni način plaćanja	</h5>
                                        <input type="text" value="{{ old('alternative_payment', $detail->alternative_payment) }}"
                                        class="default_input" name="alternative_payment"
                                        @error('alternative_payment')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">
                                        Alternativni račun za plaćanje
                                        </h5>
                                        <input type="text"
                                        class="default_input"
                                        name="alternative_payment_acc" value="{{ old('alternative_payment_acc', $detail->alternative_payment_acc) }}"
                                        @error('alternative_payment_acc')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title">  Alternativni način plaćanja 2		</h5>
                                        <input type="text" class="default_input"
                                         name="alternative_payment2" value="{{ old('alternative_payment2', $detail->alternative_payment2) }}" @error('alternative_payment2')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title"> Alternativni račun za plaćanje 2	</h5>
                                        <input type="text" class="default_input"
                                         name="alternative_payment_acc2" value="{{ old('alternative_payment_acc2', $detail->alternative_payment_acc2) }}" @error('alternative_payment_acc2')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="field_title"> PDV(%):	</h5>
                                        <input type="text" class="default_input"
                                         name="PDV" value="{{ old('PDV', $detail->PDV) }}" @error('PDV')
                                        style="border-color:red;" @enderror>
                                    </div>
                                    <div class="col-md-12">
                                    <h5 class="field_title">  Cijene uključuju PDV	</h5>
                                    <select name="include_pdv" class="default_select">
                                        <option value="1" @if($include_pdv == '1') selected @endif>Da</option>
                                        <option value="0" @if($include_pdv == '0') selected @endif>Ne</option>
                                    </select>
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

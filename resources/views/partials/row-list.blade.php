@for ($i = 0; $i < 10; $i++)                                    
<div class="row">
    <div class="col-md-3 mb-2 col-full-xl">
        <input name="name[]" type="text" class="form-control" id="name{{ $i }}" placeholder="Naziv {{ $i+1 }}" value="{{ old('name.'.$i, $invoice->goods[$i]['name'] ?? null) }}" {!! $errors->has('name.'.$i) ? 'style="border-color:red;"' : '' !!}>
    </div>
    <div class="col-md-3 col-full-xl">
        <input name="price[]" type="text" class="form-control" id="price{{ $i }}" placeholder="Cena {{ $i+1 }}" value="{{ old('price.'.$i, $invoice->goods[$i]['price'] ?? null) }}" {!! $errors->has('price.'.$i) ? 'style="border-color:red;"' : '' !!}>
    </div>
    <div class="col-md-3 col-full-xl">
        <input name="quantity[]" type="text" class="form-control" id="quantity{{ $i }}" placeholder="Kolicina {{ $i+1 }}" value="{{ old('quantity.'.$i, $invoice->goods[$i]['quantity'] ?? null) }}" {!! $errors->has('quantity.'.$i) ? 'style="border-color:red;"' : '' !!}>
    </div>
    <div class="col-md-3 col-full-xl">
        <input name="unit_measurement[]" type="text" class="form-control" id="unit_measurement{{ $i }}" placeholder="Merna  {{ $i+1 }}" value="{{ old('unit_measurement.'.$i, $invoice->goods[$i]['unit_measurement'] ?? null) }}" {!! $errors->has('unit_measurement.'.$i) ? 'style="border-color:red;"' : '' !!}>
    </div>
</div>
@endfor


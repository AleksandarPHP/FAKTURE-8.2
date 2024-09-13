
<!DOCTYPE html>
<html lang="sr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>‎</title>
        <style>
        @page { size: auto;  margin: 8mm; };
            * {
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-size: 12px;
                font-family: "Arial", sans-serif;
           
            }
            .ticket {
                margin: 0 50px 50px 50px;
            }
           header {
               width: 100%; 
               display: flex;
               margin-bottom: 50px;
           
           }
           header div {
               width: 50%;
           }
           header .header-right {
               text-align: right;
           }
           
           .print-info {
               width: 100%;
               display: flex;
               margin-top: -40px;
           }
           .print-info div {
               width: 50%;
           }
           
           .print-info .print-info-left {
               width: 100%;
           }
           
           .print-info .print-info-left div:first-of-type {
               margin-bottom: 30px;
           }
           
           .print-info .print-info-left ul {
               list-style-type: none;
               padding-left: 0;
           }
           
           .print-info .print-info-right {
               margin-left: -50px;
           }
           
           .print-info .print-info-right p {
               margin-bottom: 20px;
           }
           
           h1 {
               font-size: 24px;
               margin: 20px 0;
           }
           
           .about {
               width: 100%;
               display: flex;
           }
           
           .about div {
               width: 50%
           }
           
           .about .about-right {
               text-align: right;
           }
           
            .table  {
                margin: 30px 0;
            }
           
           .table table {
               width:100%;
           }
           
           .table table th,
           .table table td {
               text-align: center;
           }
           
           
           
           .total {
               text-align: right;
           }
           
           
           .description {
               margin-bottom: 30px;
           }
           
           .description p{
               margin: 15px 0;
           }
           
           .signature {
               margin-top: 40px;
           }
           
           footer {
               margin-top: 40px;
           }
           
           footer p {
               text-align: center;
           }
           
           header .header-right img {
               max-width: 125px;
               max-height: 70px;
           }
           .pdv-system {
               margin-bottom: 30px;
           }
           
           
           
        </style>
    </head>
    <body onload="window.print();">
        <div class="ticket">
           <header>
               <div class="header-left">
                   
               </div>
               <div class="header-right">
                @if($userDetails->image)
                <img src="{{ asset('storage/company/res_'.$userDetails->image) }}" alt="photo" class="img-fluid">
                @else
                <img src="{{ asset('assets/images/no_image.png') }}" alt="photo" class="img-fluid">
                @endif
               </div>
           </header>
           <div class="print-info">
               <div class="print-info-left">
                  <div>
                  <p><strong>
                      "{{$userDetails->company_name}}"
                  </strong></p>
                  </div>
                  <div>
                      <ul>
                        <li>{{$userDetails->adresa}}</li>
                        <li>{{$userDetails->postal_code}} {{$userDetails->city}}</li>
                        <li>JIB: {{$userDetails->JIB}}</li>
                        <li>Telefon: {{$userDetails->telefon}}</li>
                        <li>Z.R. : {{$details->bank_acc}}</li>
                      </ul>
                  </div>
               </div>
               <div class="print-info-right">
                   <p><strong>{{ __('Client') }}: </strong></p>
                   <p>{{$inv->client_company}}</p>
                   <p>{{ $inv->client_address }}</p>
                   <p>{{ $inv->client_postal_code }} {{ $inv->client_city }}</p>
                   <p>JIB: {{ $inv->jib }}</p>
               </div>
           </div>
           
           <h1>{{ __('Invoice no.') }} - {{$inv->inv_number}}/{{$inv->year}}@if($inv->fiscal_number) | {{__('According to fiscal account no.:')}} {{$inv->fiscal_number}}@else @endif</h1>
           
           <div class="about">
               <div class="about-left">
                   <p>{{__('Invoice date')}}: {{ (new DateTime($inv->date))->format('d.m.Y.') }}</p>
                   <p>{{__('Place')}}: {{$userDetails->city}}</p>
               </div>
              <div class="about-right">
                  {{__('Date of Payment')}}: {{ (new DateTime($inv->date_of_payment))->format('d.m.Y.') }}
              </div>
           </div>
           
           <div class="table">
               <table>
                   <div style='width: 100%;border-bottom: 1px solid black;'></div>
                   <thead>
                       <tr>
                           <th>{{__('Sn')}}.</th>
                           <th>{{__('Name')}}</th>
                           <th>{{__('Quantity')}}</th>
                           <th>{{__('Unit measure')}}</th>
                           <th>{{__('Unit price')}}</th>
                           <th>{{__('Price')}}</th>
                       </tr>
                       
                       <tr>
                        <td style="color: #000; width: 100%" colspan="8">
                            <div style='width: 100%;border-bottom: 1px solid black;'></div>
                        </td>
                        </tr>
                   </thead>
                 
                    
                   <tbody>
                    @php
                    $ukupno = 0;
                    $redniBroj = 1;
                    @endphp
                    @if ($inv->goods)
                        @foreach ($inv->goods as $goodsItem)
                       <tr>
                           <td>{{ $redniBroj }}.</td>
                           <td>{{ $goodsItem['name'] }}</td>
                           <td>{{ $goodsItem['quantity'] }}</td>
                           <td>{{ $goodsItem['unit_measurement'] }}</td>
                           <td>{{ number_format($goodsItem['price'], 2, ',', '.') }}</td>
                           <td>{{ number_format($goodsItem['quantity'] * $goodsItem['price'], 2, ',', '.') }}</td>
                       </tr>
                       
                       @php
                       $ukupno += ($goodsItem['quantity'] * $goodsItem['price']);
                       $redniBroj++;

                       @endphp
                       @endforeach
                        @else
                        <tr>
                            <td colspan="6">
                            {{__('The goods are not listed on this invoice')}}
                            </td>
                        </tr>
                        @endif
                   </tbody>
                   
               </table>
               <div style='width: 100%;border-bottom: 1px solid black;'></div>
           </div>
           
            @if ($details->include_pdv == 1)
           <div class="total">
               <div>
                   <p>{{__('Price without VAT')}}: <span>{{ number_format($ukupno - ($ukupno * ($details->PDV / 100)), 2, ',', '.') }}</span></p>
                   <p>{{__('VAT')}}({{$details->PDV}}%): <span>{{  $ukupno * ($details->PDV / 100) }}</span></p>
               </div>
                <p>
                    {{__('Price with VAT')}}: <span>{{ number_format($ukupno, 2, ',', '.') }}</span>
                </p>
           </div>
           @else
            <div class="total" style="width: 25%; margin-left: auto">
               <div>
                   <div style='width: 100%;border-bottom: 1px solid black;'></div>
                   <p>{{__('Price without rebate')}}: <span>{{ number_format($ukupno, 2, ',', '.') }}</span></p>
                   <p>{{__('rebate')}}: <span>0.00</span></p>
               </div>
               <div style='width: 100%;border-bottom: 1px solid black;'></div>
                <p>
                    Cijena sa rabatom: <span>{{ number_format($ukupno, 2, ',', '.') }}</span>
                </p>
           </div>
           @endif
           
           <div class="description">
               <h3>{{__('Description')}}:</h3>
               <p>{{$inv->notes}}</p>
               <h4 style="margin-top: 50px">{{__('For payment')}}: {{ number_format($ukupno, 2, ',', '.') }}KM</h4>
           </div>
            @if ($details->include_pdv == 0)
           <div class="pdv-system">
               <p style="margin-top: 50px">{{ __('The obligor is not in the VAT system') }}</p>
           </div>
           @endif
           @if($inv->issued == 1)
           <div class="signature" style="margin: 75px 0">
            <p>{{__('The invoice was issued by computer and is valid without a stamp or signature')}}</p>
            </div>
           @else
            <div class="signature" style="margin-top: 75px">
               <p><strong>{{__('Compiled the bill')}}:</strong></p>
               <div class="line">____________________</div>
               <p>{{$inv->operator}}</p>
           </div>
           @endif
           <footer>
               <p>{{$userDetails->company_name}} <span>{{__('Phone')}}: {{$userDetails->telefon}}</span></p>
           </footer>
        </div>
    </body>
</html>
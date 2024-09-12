<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'type',
        'prefix',
        'inv_number',
        'issued',
        'year',
        'fiscal_number',
        'suffix',
        'suma',
        'date',
        'time',
        'date_of_payment',
        'delivery_date',
        'method_of_payment',
        'operator',
        'reference_number',
        'jir',
        'notes',
        'email_text',
        'status',
        'client_company',
        'jib',
        'client_pdv',
        'client_adderss',
        'client_postal_code',
        'client_city',
        'client_email',
        'goods',
        'lang',
    ];

    protected $casts = [
        'goods' => 'array',
    ];

}
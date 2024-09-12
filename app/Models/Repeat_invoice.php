<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repeat_invoice extends Model
{
    protected $fillable = [
        'type',
        'suma',
        'frequency',
        'date_first_inv',
        'date_last_inv',
        'date_next_inv',
        'method_of_payment',
        'operator',
        'reference_number',
        'jir',
        'notes',
        'email_text',
        'client_company',
        'jib',
        'client_pdv',
        'client_adderss',
        'client_city',
        'client_email',
        'goods',
        'lang',
    ];

    protected $casts = [
        'goods' => 'array',
    ];
}

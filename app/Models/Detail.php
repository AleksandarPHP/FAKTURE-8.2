<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_account',
        'SWIFT',
        'bank_acc',
        'alternative_payment',
        'alternative_payment_acc',
        'alternative_payment2',
        'alternative_payment_acc2',
        'PDV',
        'include_pdv',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getNameWithoutIdAttribute()
    {
        return trim($this->bank_name.' '.$this->bank_account.' '.$this->SWIFT.' '.$this->alternative_payment.' '.$this->alternative_payment_acc.' '.$this->alternative_payment2.' '.$this->alternative_payment_acc2.' '.$this->PDV.' '.$this->include_pdv);
    }
}

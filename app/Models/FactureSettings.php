<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactureSettings extends Model
{
    protected $fileable = [
        'limit_facture',
        'fee',
        'repet_facture',
        'next_repet_facture',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getNameWithoutIdAttribute()
    {
        return trim($this->limit_facture.' '.$this->fee.' '.$this->repet_facture.' '.$this->next_repet_facture);
    }
}

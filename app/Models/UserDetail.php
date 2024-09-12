<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'company_name',
        'telefon',
        'image',
        'adresa',
        'postal_code',
        'city',
        'JIB',
        'PDV_ID',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    // public function getNameWithoutIdAttribute()
    // {
    //     return trim($this->company_name.' '.$this->telefon.' '.$this->adresa.' '.$this->JIB.' '.$this->PDV_ID);
    // }

}

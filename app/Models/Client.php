<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'first_name',
        'jmbg',
        'tel',
        'responsible_person',
        'individual',
        'city',
        'postal_code',
        'pdv_id',
        'address',
        'email',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getNameWithoutIdAttribute()
    {
        return trim($this->first_name);
    }

    public function getNameAttribute()
    {
        return trim($this->first_name).' (ID: '.$this->id.')';
    }


}

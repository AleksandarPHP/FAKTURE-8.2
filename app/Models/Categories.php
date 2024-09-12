<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getNameWithoutIdAttribute()
    {
        return trim($this->name);
    }

}

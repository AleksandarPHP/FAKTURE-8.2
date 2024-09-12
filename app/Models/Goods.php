<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable = [
        'name',
        'price',
        'pdv',
        'mijerna_jedinica',
        'kolicina'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getNameWithoutIdAttribute()
    {
        return trim($this->name);
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class);
    }
    public static function calculateTotalPrice()
    {
        return self::sum('price');
    }
}

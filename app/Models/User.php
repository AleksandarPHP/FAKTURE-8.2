<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'password', 'goods', 'is_active', 'is_admin', 'image', 'categories', 'klijenti', 'fakture', 'repeat-fakture', 'termini', 'usluge', 'pacijenti', 'specijalisti', 'statistika', 'obavjestenja'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}

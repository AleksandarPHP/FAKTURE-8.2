<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSettings extends Model
{
    protected $fillable = [
        'text',
        'signature_in_email',
        'invoice_tracking',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getNameWithoutIdAttribute()
    {
        return trim($this->text.' '.$this->signature_in_email.' '.$this->invoice_tracking);
    }
}

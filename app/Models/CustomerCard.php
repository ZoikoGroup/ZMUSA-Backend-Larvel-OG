<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class CustomerCard extends Model
{
    protected $fillable = [
        'user_id',
        'card_holder_name',
        'card_number',
        'cvv',
        'exp_month',
        'exp_year',
        'card_number_hash',
    ];

    // Encrypt card number
    public function setCardNumberAttribute($value)
    {
        $this->attributes['card_number'] = Crypt::encryptString($value);
    }

    public function getCardNumberAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Encrypt CVV
    public function setCvvAttribute($value)
    {
        $this->attributes['cvv'] = Crypt::encryptString($value);
    }

    public function getCvvAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

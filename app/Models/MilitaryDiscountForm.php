<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilitaryDiscountForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'email', 'countrycode', 'phone',
        'statusproof', 'plan', 'cat', 'concent', 'terms', 'family', 'email_sent',
    ];

    protected $casts = [
        'family' => 'array',
        'concent' => 'boolean',
        'terms' => 'boolean',
        'email_sent' => 'boolean',
    ];
}

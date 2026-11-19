<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDiscountForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'email',
        'countrycode',
        'phone',
        'statusproof',
        'school',
        'yos',
        'keepnumber',
        'plan',
        'cat',
        'concent',
        'terms',
        'email_sent', // ⭐ NEW FIELD
    ];

    protected $casts = [
        'concent' => 'boolean',
        'terms' => 'boolean',
        'keepnumber' => 'boolean',
        'email_sent' => 'boolean', // ⭐ IMPORTANT
    ];
}
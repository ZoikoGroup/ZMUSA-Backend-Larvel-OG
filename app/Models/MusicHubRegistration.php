<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicHubRegistration extends Model
{
    protected $fillable = [
        'fname',
        'email',
        'countrycode',
        'phone',
        'statusproof',
        'desc',
        'perks',
        'discount',
        'tools',
        'storage',
        'access',
        'other',
        'musicjourney',
        'concent',
        'terms',
    ];

    protected $casts = [
        'perks' => 'boolean',
        'discount' => 'boolean',
        'tools' => 'boolean',
        'storage' => 'boolean',
        'access' => 'boolean',
        'concent' => 'boolean',
        'terms' => 'boolean',
    ];
}
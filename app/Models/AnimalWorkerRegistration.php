<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalWorkerRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'email',
        'countrycode',
        'phone',
        'dob',
        'statusproof',
        'orgname',
        'jobtitle',
        'street',
        'apprt',
        'city',
        'state',
        'zipcode',
        'concent',
        'terms',
        'updates',
        'family_members',
        'rawjson',
    ];

    protected $casts = [
        'family_members' => 'array',
        'rawjson' => 'array',
        'concent' => 'boolean',
        'terms' => 'boolean',
        'updates' => 'boolean',
    ];
}

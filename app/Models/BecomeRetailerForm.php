<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeRetailerForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyName', 'website', 'name', 'job', 'email', 'phone', 'countrycode',
        'street', 'city', 'state', 'zip', 'businessTypes', 'marketingChannels',
        'planToPromotes', 'monthlyTraffic', 'promotoBrands', 'monthlyActivations',
        'agreeEligibility', 'agreeTerms'
    ];

    protected $casts = [
        'businessTypes' => 'array',
        'marketingChannels' => 'array',
        'planToPromotes' => 'array',
        'agreeEligibility' => 'boolean',
        'agreeTerms' => 'boolean',
    ];
}

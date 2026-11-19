<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerWithUsForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'website',
        'street',
        'city',
        'state',
        'zip',
        'name',
        'job',
        'email',
        'countrycode',
        'phone',
        'years_in_business',
        'monthly_sales',
        'business_types',
        'solutions',
        'sale_other_carriers',
        'target_market',
        'preferred_partnership_model',
        'bank_transfer',
        'billing_contact',
        'billing_email',
        'preferred_shipping_method',
        'agree_eligibility',
        'agree_terms',
    ];

    protected $casts = [
        'business_types' => 'array',
        'solutions' => 'array',
        'agree_eligibility' => 'boolean',
        'agree_terms' => 'boolean',
    ];
}

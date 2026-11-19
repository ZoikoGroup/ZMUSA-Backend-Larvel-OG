<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeAffiliateForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'business_type',
        'name',
        'job',
        'email',
        'phone',
        'countrycode',
        'street',
        'city',
        'state',
        'zip',
        'years_in_business',
        'monthly_sales',
        'estimated_monthly_purchase',
        'business_types',
        'sale_other_carriers',
        'plan_to_sell',
        'bank_transfer',
        'billing_contact',
        'billing_email',
        'preferred_shipping_method',
        'agree_eligibility',
        'agree_terms',
    ];

    protected $casts = [
        'business_types' => 'array',
        'plan_to_sell' => 'array',
        'agree_eligibility' => 'boolean',
        'agree_terms' => 'boolean',
    ];
}

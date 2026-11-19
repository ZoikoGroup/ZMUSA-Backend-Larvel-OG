<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeHook extends Model
{
    protected $table = 'stripe_hooks';

    protected $fillable = [
        'event_id',
        'event_type',
        'payment_intent_id',
        'charge_id',
        'customer_id',
        'status',
        'currency',
        'amount',
        'payment_method_details',
        'billing_details',
        'raw_payload',
    ];

    protected $casts = [
        'payment_method_details' => 'array',
        'billing_details' => 'array',
        'raw_payload' => 'array',
    ];
}

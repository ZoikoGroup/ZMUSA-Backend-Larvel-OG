<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BqOrder extends Model
{
    use HasFactory;

    protected $table = 'bqorders';

    protected $fillable = [
        'billing_address',
        'shipping_address',
        'shipping_option',     // ✅ NEW
        'card_address',
        'cart',
        'totals',
        'coupon',
        'agreed_to_terms',
        'payment_type_id',
        'payment_method_id',
        'subscriber_id',
        'address_id',
        'address_attributes',
        'service_address_id',
        'line_id',
        'shipping_address_id',
        'bequick_order_id',
        'bequick_order_amount',
        'card_details',
        'raw_data',
    ];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'shipping_option' => 'array',   // ✅ NEW CAST
        'card_address' => 'array',
        'cart' => 'array',
        'totals' => 'array',
        'card_details' => 'array',
        'address_attributes' => 'array',
        'agreed_to_terms' => 'boolean',
    ];
}

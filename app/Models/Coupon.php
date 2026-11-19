<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'limit',
        'user_id',
        'discount',
        'type',
        'related_product',
        'related_plan',
        'is_use_once_per_customer',   // <-- added here
    ];

    protected $casts = [
        'related_product' => 'array',
        'related_plan'    => 'array',
        'is_use_once_per_customer' => 'boolean',  // <-- added here
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

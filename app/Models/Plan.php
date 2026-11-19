<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'bq_id',
        'plan_type_id',
        'plan_type', // slug of the plan type
        'title',
        'slug',
        'sub_title',
        'tag',
        'price',
        'sale_price',
        'currency',
        'duration_type',
        'duration_value',
        'features',
        'status',
        'order',
        'image_url',
        'featured_image',
        'meta_title',
        'meta_slug',
        'meta_description',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'duration_value' => 'string', // store as comma-separated string
    ];

    public function planType()
    {
        return $this->belongsTo(PlanType::class, 'plan_type_id');
    }

    // Accessor for plan_type slug
    public function getPlanTypeSlugAttribute()
    {
        return $this->planType?->slug ?? $this->plan_type;
    }

    public function getFeaturesListAttribute()
    {
        if (!is_array($this->features)) {
            return [];
        }

        return collect($this->features)->map(fn($feature) => $feature['text'] ?? '')->toArray();
    }
}

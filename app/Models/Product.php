<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'product_type',
        'image_url',
        'plan_id',
        'product_discount_type_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price_uk',
        'price_usa',
        'discount',
        'featured',
        'model_number',
        'network',
        'sku',
        'in_stock',
        'technical_specs',
        'perks',
        'faqs',
        'whats_included',
        'images',
        'warranty',
        'condition_label',
        'related_products',
        'variants',
    ];

    protected $casts = [
        'price_uk' => 'decimal:2',
        'price_usa' => 'decimal:2',
        'discount' => 'decimal:2',
        'featured' => 'boolean',
        'in_stock' => 'boolean',
        'variants' => 'array',
        'technical_specs' => 'array',
        'perks' => 'array',
        'faqs' => 'array',
        'whats_included' => 'array',
        'images' => 'array',
        'related_products' => 'array',
    ];

    protected static function booted(): void
    {
        // Generate slug
        static::creating(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        // Normalize JSON empty values
        static::saving(function ($product) {
            foreach ([
                'variants', 'technical_specs', 'perks', 'faqs',
                'whats_included', 'images', 'related_products'
            ] as $key) {
                if ($product->{$key} === '') {
                    $product->{$key} = null;
                }
            }
        });

        // Rename uploaded images automatically
        static::saved(function ($product) {
            $product->renameUploadedImages();
        });
    }

    // Generate unique slug
    protected static function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    // ----------------------------------------------------------
    //  IMAGE RENAME LOGIC
    // ----------------------------------------------------------
    protected function renameUploadedImages(): void
    {
        $disk = Storage::disk('public');

        if (!$this->slug) {
            return;
        }

        $slug = $this->slug;
        $changed = false;

        // -------------------
        // MAIN IMAGE → slug.jpg
        // -------------------
        if ($this->image_url && $disk->exists($this->image_url)) {
            $ext = pathinfo($this->image_url, PATHINFO_EXTENSION) ?: 'jpg';
            $newMain = "products/{$slug}.{$ext}";

            if ($this->image_url !== $newMain) {
                if ($disk->exists($newMain)) {
                    $newMain = "products/{$slug}-" . time() . ".{$ext}";
                }

                $disk->move($this->image_url, $newMain);
                $this->image_url = $newMain;
                $changed = true;
            }
        }

        // -------------------
        // GALLERY IMAGES → slug-1, slug-2, slug-3...
        // -------------------
        $gallery = $this->images ?: [];
        $newGallery = [];
        $index = 1;

        foreach ($gallery as $img) {
            if (!$img || !$disk->exists($img)) {
                continue;
            }

            $ext = pathinfo($img, PATHINFO_EXTENSION) ?: 'jpg';
            $newPath = "products/{$slug}-{$index}.{$ext}";

            if ($img !== $newPath) {
                if ($disk->exists($newPath)) {
                    $newPath = "products/{$slug}-{$index}-" . time() . ".{$ext}";
                }

                $disk->move($img, $newPath);
            }

            $newGallery[] = $newPath;
            $index++;
            $changed = true;
        }

        // Save updates
        if ($changed) {
            $this->images = $newGallery;
            $this->saveQuietly();
        }
    }

    // Relationships
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function discountType()
    {
        return $this->belongsTo(DiscountType::class, 'product_discount_type_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    // Primary image accessor
    public function getPrimaryImageAttribute()
    {
        $images = $this->images;

        if (is_array($images) && count($images)) {
            return $images[0];
        }

        return $this->image_url;
    }
}

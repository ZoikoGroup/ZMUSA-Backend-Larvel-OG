<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'alt_text',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'status',
        'published_at',
        'user_id'
    ];

    protected $casts = [
        'meta_keywords' => 'array', // 👈 IMPORTANT
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // Automatically generate slug if not provided
            $post->slug = $post->slug ?? Str::slug($post->title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

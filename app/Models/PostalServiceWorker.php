<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostalServiceWorker extends Model
{
    protected $fillable = ['data', 'file_path'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get full URL of the uploaded file (for API or frontend)
     */
    public function getFileUrlAttribute()
    {
        return $this->file_path
            ? Storage::disk('public')->url($this->file_path)
            : null;
    }

    /**
     * Accessor for Filament view compatibility
     */
    public function getFilePathAttribute($value)
    {
        return $value ? $value : null;
    }
}

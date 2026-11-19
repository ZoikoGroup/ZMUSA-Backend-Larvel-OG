<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    /**
     * Modify form data before creating the record.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate slug if empty
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set author automatically
        $data['user_id'] = auth()->id();

        // Set published_at automatically if post is published
        if (($data['status'] ?? null) === 'published') {
            $data['published_at'] = Carbon::now();
        } else {
            $data['published_at'] = null;
        }

        return $data;
    }
}

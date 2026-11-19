<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    /**
     * Actions available in header.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutate data before updating.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;

        // Do NOT auto-change slug unless user edits it manually
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Change published_at ONLY when changing from draft → published
        if (
            ($data['status'] ?? null) === 'published' &&
            ($record->status !== 'published')
        ) {
            $data['published_at'] = Carbon::now();
        }

        // If reverting to draft, published_at becomes NULL
        if (($data['status'] ?? null) === 'draft') {
            $data['published_at'] = null;
        }

        return $data;
    }
}

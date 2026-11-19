<?php

namespace App\Filament\Resources\BlackFridayFormSubmissionResource\Pages;

use App\Filament\Resources\BlackFridayFormSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlackFridayFormSubmission extends EditRecord
{
    protected static string $resource = BlackFridayFormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

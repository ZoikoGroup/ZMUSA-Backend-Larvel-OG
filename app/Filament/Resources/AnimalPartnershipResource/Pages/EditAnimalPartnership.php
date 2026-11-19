<?php

namespace App\Filament\Resources\AnimalPartnershipResource\Pages;

use App\Filament\Resources\AnimalPartnershipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnimalPartnership extends EditRecord
{
    protected static string $resource = AnimalPartnershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\AnimalPartnershipResource\Pages;

use App\Filament\Resources\AnimalPartnershipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnimalPartnerships extends ListRecords
{
    protected static string $resource = AnimalPartnershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

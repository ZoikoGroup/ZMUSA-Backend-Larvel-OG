<?php

namespace App\Filament\Resources\AnimalWorkerRegistrationResource\Pages;

use App\Filament\Resources\AnimalWorkerRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnimalWorkerRegistrations extends ListRecords
{
    protected static string $resource = AnimalWorkerRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

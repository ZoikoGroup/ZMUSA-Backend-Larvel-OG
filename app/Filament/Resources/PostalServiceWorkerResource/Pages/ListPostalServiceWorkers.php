<?php

namespace App\Filament\Resources\PostalServiceWorkerResource\Pages;

use App\Filament\Resources\PostalServiceWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostalServiceWorkers extends ListRecords
{
    protected static string $resource = PostalServiceWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

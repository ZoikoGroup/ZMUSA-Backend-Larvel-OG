<?php

namespace App\Filament\Resources\BecomeRetailerFormResource\Pages;

use App\Filament\Resources\BecomeRetailerFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBecomeRetailerForms extends ListRecords
{
    protected static string $resource = BecomeRetailerFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

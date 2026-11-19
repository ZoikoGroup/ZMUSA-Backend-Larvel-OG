<?php

namespace App\Filament\Resources\BqorderResource\Pages;

use App\Filament\Resources\BqorderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBqorders extends ListRecords
{
    protected static string $resource = BqorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

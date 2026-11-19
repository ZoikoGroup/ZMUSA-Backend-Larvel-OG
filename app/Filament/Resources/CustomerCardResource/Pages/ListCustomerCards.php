<?php

namespace App\Filament\Resources\CustomerCardResource\Pages;

use App\Filament\Resources\CustomerCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerCards extends ListRecords
{
    protected static string $resource = CustomerCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

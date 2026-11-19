<?php

namespace App\Filament\Resources\MilitaryDiscountFormResource\Pages;

use App\Filament\Resources\MilitaryDiscountFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMilitaryDiscountForms extends ListRecords
{
    protected static string $resource = MilitaryDiscountFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

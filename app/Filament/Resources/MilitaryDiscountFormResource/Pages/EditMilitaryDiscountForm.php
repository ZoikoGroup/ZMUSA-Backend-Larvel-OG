<?php

namespace App\Filament\Resources\MilitaryDiscountFormResource\Pages;

use App\Filament\Resources\MilitaryDiscountFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMilitaryDiscountForm extends EditRecord
{
    protected static string $resource = MilitaryDiscountFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\CustomerCardResource\Pages;

use App\Filament\Resources\CustomerCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerCard extends EditRecord
{
    protected static string $resource = CustomerCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

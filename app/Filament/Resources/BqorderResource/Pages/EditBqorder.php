<?php

namespace App\Filament\Resources\BqorderResource\Pages;

use App\Filament\Resources\BqorderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBqorder extends EditRecord
{
    protected static string $resource = BqorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

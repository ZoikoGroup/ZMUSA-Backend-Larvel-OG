<?php

namespace App\Filament\Resources\SwitchSaveResource\Pages;

use App\Filament\Resources\SwitchSaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSwitchSave extends EditRecord
{
    protected static string $resource = SwitchSaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

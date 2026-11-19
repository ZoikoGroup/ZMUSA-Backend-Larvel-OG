<?php

namespace App\Filament\Resources\BecomeRetailerFormResource\Pages;

use App\Filament\Resources\BecomeRetailerFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBecomeRetailerForm extends EditRecord
{
    protected static string $resource = BecomeRetailerFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

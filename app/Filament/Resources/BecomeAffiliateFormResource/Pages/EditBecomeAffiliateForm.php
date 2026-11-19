<?php

namespace App\Filament\Resources\BecomeAffiliateFormResource\Pages;

use App\Filament\Resources\BecomeAffiliateFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBecomeAffiliateForm extends EditRecord
{
    protected static string $resource = BecomeAffiliateFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PartnerWithUsFormResource\Pages;

use App\Filament\Resources\PartnerWithUsFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerWithUsForm extends EditRecord
{
    protected static string $resource = PartnerWithUsFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

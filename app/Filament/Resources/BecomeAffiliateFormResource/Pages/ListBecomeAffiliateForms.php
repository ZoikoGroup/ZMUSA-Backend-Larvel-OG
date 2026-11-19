<?php

namespace App\Filament\Resources\BecomeAffiliateFormResource\Pages;

use App\Filament\Resources\BecomeAffiliateFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBecomeAffiliateForms extends ListRecords
{
    protected static string $resource = BecomeAffiliateFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

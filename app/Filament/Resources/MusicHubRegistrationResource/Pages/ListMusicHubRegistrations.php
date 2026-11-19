<?php

namespace App\Filament\Resources\MusicHubRegistrationResource\Pages;

use App\Filament\Resources\MusicHubRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMusicHubRegistrations extends ListRecords
{
    protected static string $resource = MusicHubRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

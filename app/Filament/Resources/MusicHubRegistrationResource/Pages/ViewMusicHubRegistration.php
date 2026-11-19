<?php

namespace App\Filament\Resources\MusicHubRegistrationResource\Pages;

use App\Filament\Resources\MusicHubRegistrationResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewMusicHubRegistration extends ViewRecord
{
    protected static string $resource = MusicHubRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
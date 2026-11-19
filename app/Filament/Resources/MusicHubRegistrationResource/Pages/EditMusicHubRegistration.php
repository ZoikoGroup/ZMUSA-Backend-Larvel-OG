<?php

namespace App\Filament\Resources\MusicHubRegistrationResource\Pages;

use App\Filament\Resources\MusicHubRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMusicHubRegistration extends EditRecord
{
    protected static string $resource = MusicHubRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

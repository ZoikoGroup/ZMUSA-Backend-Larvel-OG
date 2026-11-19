<?php

namespace App\Filament\Resources\CustomerCardResource\Pages;

use App\Filament\Resources\CustomerCardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerCard extends CreateRecord
{
    protected static string $resource = CustomerCardResource::class;
}

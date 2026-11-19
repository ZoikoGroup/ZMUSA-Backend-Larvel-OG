<?php

namespace App\Filament\Resources\StudentDiscountFormResource\Pages;

use App\Filament\Resources\StudentDiscountFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentDiscountForms extends ListRecords
{
    protected static string $resource = StudentDiscountFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

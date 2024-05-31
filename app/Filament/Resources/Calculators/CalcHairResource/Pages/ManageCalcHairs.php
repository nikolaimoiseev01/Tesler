<?php

namespace App\Filament\Resources\Calculators\CalcHairResource\Pages;

use App\Filament\Resources\Calculators\CalcHairResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCalcHairs extends ManageRecords
{
    protected static string $resource = CalcHairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

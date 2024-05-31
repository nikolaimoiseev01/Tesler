<?php

namespace App\Filament\Resources\Calculators\CalcCosmeticResource\Pages;

use App\Filament\Resources\Calculators\CalcCosmeticResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCalcCosmetics extends ManageRecords
{
    protected static string $resource = CalcCosmeticResource::class;

    protected static ?string $title = 'Калькулятор косметологии';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

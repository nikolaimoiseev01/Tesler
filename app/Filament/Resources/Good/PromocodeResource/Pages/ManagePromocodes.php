<?php

namespace App\Filament\Resources\Good\PromocodeResource\Pages;

use App\Filament\Resources\Good\PromocodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePromocodes extends ManageRecords
{
    protected static string $resource = PromocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected static ?string $title = 'Промокоды';
}

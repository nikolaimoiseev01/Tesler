<?php

namespace App\Filament\Resources\RefreshLogResource\Pages;

use App\Filament\Resources\RefreshLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRefreshLogs extends ManageRecords
{
    protected static string $resource = RefreshLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }

    protected static ?string $title = 'История обновлений';

}

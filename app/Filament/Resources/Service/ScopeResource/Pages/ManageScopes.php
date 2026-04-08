<?php

namespace App\Filament\Resources\Service\ScopeResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Service\ScopeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScopes extends ManageRecords
{
    protected static string $resource = ScopeResource::class;
    protected static ?string $title = 'Сферы услуг';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

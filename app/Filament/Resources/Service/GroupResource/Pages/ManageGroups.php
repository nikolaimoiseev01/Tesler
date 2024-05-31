<?php

namespace App\Filament\Resources\Service\GroupResource\Pages;

use App\Filament\Resources\Service\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGroups extends ManageRecords
{
    protected static string $resource = GroupResource::class;
    protected static ?string $title = 'Группы услуг';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

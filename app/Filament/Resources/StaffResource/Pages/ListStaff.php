<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use App\Models\Service\Service;
use App\Models\Staff;
use App\Services\ServiceYcOperations;
use App\Services\StaffYcOperations;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\App;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    protected static ?string $title = 'Сотрудники';

    protected function getHeaderActions(): array
    {
        return [
            Action::make("Refresh YC")
                ->label('Синхронизироваться с YCLients')
                ->requiresConfirmation()
                ->modalDescription('Вы уверены, что хотите это сделать?')
                ->action(function () {
                    App::make(StaffYcOperations::class)->refreshAll();
                }),
        ];
    }
}

<?php

namespace App\Filament\Resources\Service\ServiceResource\Pages;

use App\Filament\Resources\Service\ServiceResource;
use App\Models\Service\Service;
use App\Services\ServiceYcOperations;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\App;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;
    protected static ?string $title = 'Услуги';

    protected function getHeaderActions(): array
    {
        return [
            Action::make("Refresh YC")
                ->label('Синхронизироваться с YCLients')
                ->requiresConfirmation()
                ->modalDescription('Вы уверены, что хотите это сделать? Это займет несколько минут, так как проверит абсолютно все услуги в системе.')
                ->action(function (Service $service) {
                    $services = Service::all();
                    App::make(ServiceYcOperations::class)->refreshAll();
                }),
        ];
    }
}

<?php

namespace App\Filament\Resources\Good\GoodResource\Pages;

use App\Filament\Resources\Good\GoodResource;
use App\Models\Good\Good;
use App\Models\Service\Service;
use App\Services\GoodYcOperations;
use App\Services\ServiceYcOperations;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\App;

class ListGoods extends ListRecords
{
    protected static string $resource = GoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("Refresh YC")
                ->label('Синхронизироваться с YCLients')
                ->requiresConfirmation()
                ->modalDescription('Вы уверены, что хотите это сделать? Это займет несколько минут, так как проверит абсолютно все товары в системе.')
                ->action(function (Service $service) {
                    App::make(GoodYcOperations::class)->fullGoodsUpdate();
                }),
        ];
    }

    protected static ?string $title = 'Товары';
}

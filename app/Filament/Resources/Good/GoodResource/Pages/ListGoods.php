<?php

namespace App\Filament\Resources\Good\GoodResource\Pages;

use App\Filament\Resources\Good\GoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget;

class ListGoods extends ListRecords
{
    protected static string $resource = GoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected static ?string $title = 'Товары';
}

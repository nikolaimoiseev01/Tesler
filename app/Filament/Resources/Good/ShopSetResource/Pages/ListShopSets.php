<?php

namespace App\Filament\Resources\Good\ShopSetResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Good\ShopSetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShopSets extends ListRecords
{
    protected static string $resource = ShopSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected static ?string $title = 'Шопсеты';
}

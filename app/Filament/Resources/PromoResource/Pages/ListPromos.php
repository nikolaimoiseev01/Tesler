<?php

namespace App\Filament\Resources\PromoResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\PromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromos extends ListRecords
{
    protected static string $resource = PromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected static ?string $title = 'Промо-акции';
}

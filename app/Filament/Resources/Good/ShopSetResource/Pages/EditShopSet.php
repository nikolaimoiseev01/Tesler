<?php

namespace App\Filament\Resources\Good\ShopSetResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Good\ShopSetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShopSet extends EditRecord
{
    protected static string $resource = ShopSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

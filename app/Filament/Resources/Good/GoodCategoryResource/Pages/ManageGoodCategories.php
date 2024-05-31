<?php

namespace App\Filament\Resources\Good\GoodCategoryResource\Pages;

use App\Filament\Resources\Good\GoodCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGoodCategories extends ManageRecords
{
    protected static string $resource = GoodCategoryResource::class;
    protected static ?string $title = 'Категории товаров';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}

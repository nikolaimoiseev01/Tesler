<?php

namespace App\Filament\Resources\InteriorPhotoResource\Pages;

use App\Filament\Resources\InteriorPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInteriorPhotos extends ManageRecords
{
    protected static string $resource = InteriorPhotoResource::class;

    protected static ?string $title = 'Фото интерьера';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

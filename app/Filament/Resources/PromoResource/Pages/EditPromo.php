<?php

namespace App\Filament\Resources\PromoResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\PromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromo extends EditRecord
{
    protected static string $resource = PromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record['title'];
    }
}

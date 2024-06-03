<?php

namespace App\Filament\Resources\Good\OrderResource\Pages;

use App\Filament\Resources\Good\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Заказ от {$this->record['created_at']}";
    }
}

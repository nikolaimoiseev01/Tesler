<?php

namespace App\Filament\Resources\Good\GoodResource\Pages;

use App\Filament\Resources\Good\GoodResource;
use App\Models\Good\Good;
use App\Models\Service\Service;
use App\Services\ServiceYcOperations;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditGood extends EditRecord
{
    protected static string $resource = GoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("Страница на сайте")
                ->label('Страница на сайте')
                ->url(fn(Good $good) => route('good_page', $good['id']))
                ->tooltip('Откроется в новом окне')
                ->openUrlInNewTab()
        ];
    }

    public function getTitle(): string
    {
        return $this->record['name'];
    }
}

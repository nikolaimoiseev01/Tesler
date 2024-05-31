<?php

namespace App\Filament\Resources\Service\ServiceResource\Pages;

use App\Filament\Resources\Service\ServiceResource;
use App\Models\Service\Service;
use App\Services\ServiceYcOperations;
use App\Services\YcApiRequest;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("Refresh YC")
                ->label('Обновить YC инфо')
                ->requiresConfirmation()
                ->action(function (Service $service) {
                    $service = collect([$service]);
                    App::make(ServiceYcOperations::class)->update($service);
                })
        ];
    }

    public function getTitle(): string
    {
        return $this->record['name'];
    }

}

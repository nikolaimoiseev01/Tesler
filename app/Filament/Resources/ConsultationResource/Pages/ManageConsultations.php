<?php

namespace App\Filament\Resources\ConsultationResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ConsultationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConsultations extends ManageRecords
{
    protected static string $resource = ConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected static ?string $title = 'Консультации';
}

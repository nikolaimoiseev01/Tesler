<?php

namespace App\Filament\Resources\ConsultationResource\Pages;

use App\Filament\Resources\ConsultationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConsultations extends ManageRecords
{
    protected static string $resource = ConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected static ?string $title = 'Консультации';
}
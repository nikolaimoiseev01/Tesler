<?php

namespace App\Filament\Resources\Course\CourseResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Course\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;


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

<?php

namespace App\Filament\Resources\Course\CourseResource\Pages;

use App\Filament\Resources\Course\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    public function getTitle(): string
    {
        return $this->record['title'];
    }
}

<?php

namespace App\Filament\Resources\Course\CourseAppResource\Pages;

use App\Filament\Resources\Course\CourseAppResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseApp extends EditRecord
{
    protected static string $resource = CourseAppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

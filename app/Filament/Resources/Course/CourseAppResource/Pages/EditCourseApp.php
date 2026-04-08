<?php

namespace App\Filament\Resources\Course\CourseAppResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Course\CourseAppResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseApp extends EditRecord
{
    protected static string $resource = CourseAppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

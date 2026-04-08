<?php

namespace App\Filament\Resources\Course\CourseAppResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Course\CourseAppResource;
use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseApps extends ListRecords
{
    protected static string $resource = CourseAppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableRecordUrlUsing (): ?Closure
    {
        return null;
    }

    protected static ?string $title = 'Заявки на курсы';
}

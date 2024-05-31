<?php

namespace App\Filament\Resources\Course\CourseResource\Pages;

use App\Filament\Resources\Course\CourseResource;
use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected static ?string $title = 'Курсы';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}

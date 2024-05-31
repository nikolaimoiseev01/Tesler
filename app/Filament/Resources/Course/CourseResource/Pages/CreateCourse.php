<?php

namespace App\Filament\Resources\Course\CourseResource\Pages;

use App\Filament\Resources\Course\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
}

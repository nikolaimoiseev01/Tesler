<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\HtmlString;

class EditStaff extends EditRecord
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }


    public function getTitle(): HtmlString
    {
        $avatar = "<img src='{$this->record['yc_avatar']}' style='height: 5rem; width: 5rem; display: inline; margin-right: 20px;' class='max-w-none object-cover object-center rounded-full ring-white dark:ring-gray-900'>";
        return new HtmlString($avatar .  $this->record['yc_name']);

    }
}

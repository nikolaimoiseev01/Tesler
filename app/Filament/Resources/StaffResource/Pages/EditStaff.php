<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use App\Models\Good\Good;
use App\Models\Staff;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\HtmlString;

class EditStaff extends EditRecord
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("Страница на сайте")
                ->label('Страница на сайте')
                ->url(fn(Staff $staff) => route('staff_page', $staff['yc_id']))
                ->tooltip('Откроется в новом окне')
                ->openUrlInNewTab()
        ];
    }


    public function getTitle(): HtmlString
    {
        $avatar = "<img src='{$this->record['yc_avatar']}' style='height: 5rem; width: 5rem; display: inline; margin-right: 20px;' class='max-w-none object-cover object-center rounded-full ring-white dark:ring-gray-900'>";
        return new HtmlString($avatar .  $this->record['yc_name']);

    }
}

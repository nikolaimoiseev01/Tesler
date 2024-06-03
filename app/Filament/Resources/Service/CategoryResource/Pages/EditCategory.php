<?php

namespace App\Filament\Resources\Service\CategoryResource\Pages;

use App\Filament\Resources\Service\CategoryResource;
use App\Models\Good\Good;
use App\Models\Service\Category;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make("Страница на сайте")
                ->label('Страница на сайте')
                ->url(fn(Category $category ) => route('scope_page', $category['scope_id']) . '#category_' . $category['id'])
                ->tooltip('Откроется в новом окне')
                ->openUrlInNewTab()
        ];
    }

    public function getTitle(): string
    {
        return 'Категория: ' . $this->record['name'];
    }
}

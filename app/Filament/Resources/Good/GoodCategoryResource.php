<?php

namespace App\Filament\Resources\Good;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Good\GoodCategoryResource\Pages\ManageGoodCategories;
use App\Filament\Resources\Good\GoodCategoryResource\Pages;
use App\Filament\Resources\Good\GoodCategoryResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\GoodCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GoodCategoryResource extends Resource
{
    protected static ?string $model = GoodCategory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Категории товаров';
    protected static string | \UnitEnum | null $navigationGroup = 'Модель товаров';

    public function getTitle(): String
    {
        return 'test';
    }
    protected static ?string $title = 'Custom Page Title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->label('Название')
                    ->maxLength(255),
                Grid::make(2)->schema([
                    SpatieMediaLibraryFileUpload::make('pic_goodcategory')
                        ->collection('pic_goodcategory')
                        ->image()
                        ->label('Шапка на странице категории')
                        ->imageEditor()
                        ->imageEditorMode(2)
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('1920')
                        ->imageResizeTargetHeight('1080')
                        ->columnSpan(['lg' => 1]),
                        SpatieMediaLibraryFileUpload::make('pic_goodcategory_small')
                            ->collection('pic_goodcategory_small')
                            ->image()
                            ->label('Изображения для квадратных фильтров')
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->columnSpan(['lg' => 1]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('title')
                    ->sortable()
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('good_count2')
                    ->label('Название')
                    ->getStateUsing(function (Model $record) {
                        $count = Good::whereJsonContains('good_category_id', $record['id'])->count();
                        return $count;
                    })
                    ->label('Товаров в категории'),
            ])
            ->defaultSort('position')
            ->filters([
                SelectFilter::make('id')
                    ->options(GoodCategory::all()->pluck('title', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('Категория'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->reorderable('position')
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGoodCategories::route('/'),
        ];
    }
}

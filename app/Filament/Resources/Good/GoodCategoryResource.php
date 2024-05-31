<?php

namespace App\Filament\Resources\Good;

use App\Filament\Resources\Good\GoodCategoryResource\Pages;
use App\Filament\Resources\Good\GoodCategoryResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\GoodCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GoodCategoryResource extends Resource
{
    protected static ?string $model = GoodCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Категории товаров';
    protected static ?string $navigationGroup = 'Модель товаров';

    public function getTitle(): String
    {
        return 'test';
    }
    protected static ?string $title = 'Custom Page Title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->label('Название')
                    ->maxLength(255),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('pic_goodcategory')
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
                        Forms\Components\SpatieMediaLibraryFileUpload::make('pic_goodcategory_small')
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
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
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
                Tables\Filters\SelectFilter::make('id')
                    ->options(GoodCategory::all()->pluck('title', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('Категория'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->reorderable('position')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGoodCategories::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Service;

use App\Filament\Resources\Service\ServiceResource\Pages;
use App\Filament\Resources\Service\ServiceResource\RelationManagers;
use App\Models\Service\Category;
use App\Models\Service\Scope;
use App\Models\Service\Service;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Услуги';
    protected static ?string $navigationGroup = 'Популярное';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make('xl')->schema([
                    Tabs::make('Tabs')
                        ->tabs([
                            Tabs\Tab::make('Общее')
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->label('Название на сайте')
                                            ->columnSpan(4)
                                            ->maxLength(255),
                                        Forms\Components\Select::make('service_type_id')
                                            ->relationship(name: 'service_type', titleAttribute: 'name')
                                            ->columnSpan(2)
                                            ->label('Тип услуги')
                                            ->required(),
                                        Forms\Components\Toggle::make('flg_active')
                                            ->label('Есть на сайте')
                                            ->inline(false)
                                            ->columnSpan(1)
                                            ->required(),
                                    ])->columns(7),
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\Select::make('scope_id')
                                            ->relationship(name: 'scope', titleAttribute: 'name')
                                            ->options(Scope::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->label('Сфера')
                                            ->required(),
                                        Forms\Components\Select::make('category_id')
                                            ->relationship(name: 'category', titleAttribute: 'name')
                                            ->options(Category::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->label('Категория')
                                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "Сфера: {$record->scope->name}, категория: {$record->name}")
                                            ->required(),
                                        Forms\Components\Select::make('group_id')
                                            ->relationship(name: 'group', titleAttribute: 'name')
                                            ->label('Группа')
                                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "Категория: {$record->category->name}, группа: {$record->name}")
                                            ->required(),
                                    ]),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Textarea::make('desc_small')
                                            ->label('Описание маленькое')
                                            ->required()
                                            ->rows(6),
                                        Forms\Components\Textarea::make('desc')
                                            ->rows(6)
                                            ->required()
                                            ->label('Описание'),
                                    ]),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Textarea::make('proccess')
                                            ->label('Процесс')
                                            ->required()
                                            ->rows(6),
                                        Forms\Components\Textarea::make('result')
                                            ->rows(6)
                                            ->required()
                                            ->label('Результат'),
                                    ]),

                                ]),
                            Tabs\Tab::make('Изображения')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('pic_main')
                                            ->collection('pic_main')
                                            ->image()
                                            ->reorderable()
                                            ->label('')
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->imageResizeMode('cover')
                                            ->label('Основное изображение')
                                            ->columnSpan(1)
                                            ->imageCropAspectRatio('16:10'),
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('pic_proccess')
                                            ->collection('pic_proccess')
                                            ->image()
                                            ->reorderable()
                                            ->columnSpan(1)
                                            ->label('')
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->imageResizeMode('cover')
                                            ->label('Изображение процесса')
                                            ->imageCropAspectRatio('9:16'),
                                    ])->columns(2),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('service_examples')
                                        ->collection('service_examples')
                                        ->image()
                                        ->multiple()
                                        ->reorderable()
                                        ->label('')
                                        ->imageEditor()
                                        ->panelLayout('grid')
                                        ->imageEditorMode(2)
                                        ->imageResizeMode('cover')
                                        ->label('Примеры')
                                        ->imageCropAspectRatio('11:16')
                                        ->columnSpan(['lg' => 1]),
                                ]),
                            Tabs\Tab::make('Получено от YClients')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        Placeholder::make('Название')
                                            ->content(fn(Service $record): string => $record['yc_title']),
                                        Placeholder::make('Категория')
                                            ->content(fn(Service $record): string => $record['yc_category_name']),
                                    ]),
                                    Placeholder::make('Коммент')
                                        ->content(fn(Service $record): string => $record['yc_comment']),
                                    Forms\Components\Grid::make(5)->schema([
                                        Placeholder::make("yc_id")
                                            ->content(fn(Service $record): string => $record['yc_id']),
                                        Placeholder::make('Цена_MIN')
                                            ->content(fn(Service $record): string => $record['yc_price_min']),
                                        Placeholder::make('Цена MAX')
                                            ->content(fn(Service $record): string => $record['yc_price_max']),
                                        Placeholder::make('Длительность')
                                            ->content(fn(Service $record): string => $record['yc_duration']),
                                    ]),
                                ]),
                            Tabs\Tab::make('Допы к этой услуге')
                                ->schema([
                                    Repeater::make('service_adds')
                                        ->simple(
                                            Select::make('service_id')
                                                ->label('')
                                                ->options(Service::all()->pluck('name', 'id'))
                                                ->searchable()
                                                ->required()
                                        )
                                        ->label('')
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить доп'),
                                        )
                                        ->grid(2)
                                ]),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('yc_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('flg_active')
                    ->badge()
                    ->getStateUsing(function (Model $record) {
                        return $record['flg_active'] == 1 ? 'Да' : 'Нет';
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Да' => 'success',
                        'Нет' => 'warning'
                    })
                    ->label('Активно?')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название для сайта')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yc_category_name')
                    ->searchable()
                    ->label('YC Категория')
                    ->sortable(),
                Tables\Columns\TextColumn::make('scope.name')
                    ->searchable()
                    ->label('Сфера')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->label('Категория')
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->searchable()
                    ->label('Группа')
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_type.name')
                    ->label('Тип')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('scope_id')
                    ->label('Сфера')
                    ->relationship('scope', 'name'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('group_id')
                    ->label('Группа')
                    ->relationship('group', 'name'),
                Tables\Filters\SelectFilter::make('yc_category_name')
                    ->options(Service::all()->whereNotNull('yc_category_name')->pluck('yc_category_name')->unique())
                    ->label('YC Категория'),
            ])->filtersFormColumns(2)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

}

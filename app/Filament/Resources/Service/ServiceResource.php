<?php

namespace App\Filament\Resources\Service;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use App\Filament\Resources\Service\ServiceResource\Pages\ListServices;
use App\Filament\Resources\Service\ServiceResource\Pages\CreateService;
use App\Filament\Resources\Service\ServiceResource\Pages\EditService;
use App\Filament\Resources\Service\ServiceResource\Pages;
use App\Filament\Resources\Service\ServiceResource\RelationManagers;
use App\Models\Service\Category;
use App\Models\Service\Scope;
use App\Models\Service\Service;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Услуги';
    protected static string | \UnitEnum | null $navigationGroup = 'Популярное';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make('xl')->schema([
                    Tabs::make('Tabs')
                        ->tabs([
                            Tab::make('Общее')
                                ->schema([
                                    Grid::make(3)->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->label('Название на сайте')
                                            ->columnSpan(4)
                                            ->maxLength(255),
                                        Select::make('service_type_id')
                                            ->relationship(name: 'service_type', titleAttribute: 'name')
                                            ->columnSpan(2)
                                            ->label('Тип услуги')
                                            ->required(),
                                        Toggle::make('flg_active')
                                            ->label('Есть на сайте')
                                            ->inline(false)
                                            ->columnSpan(1)
                                            ->required(),
                                    ])->columns(7),
                                    Grid::make(3)->schema([
                                        Select::make('scope_id')
                                            ->relationship(name: 'scope', titleAttribute: 'name')
                                            ->options(Scope::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->label('Сфера')
                                            ->required(),
                                        Select::make('category_id')
                                            ->relationship(name: 'category', titleAttribute: 'name')
                                            ->options(Category::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->label('Категория')
                                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "Сфера: {$record->scope->name}, категория: {$record->name}")
                                            ->required(),
                                        Select::make('group_id')
                                            ->relationship(name: 'group', titleAttribute: 'name')
                                            ->label('Группа')
                                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "Категория: {$record->category->name}, группа: {$record->name}")
                                            ->required(),
                                    ]),
                                    Grid::make(2)->schema([
                                        Textarea::make('desc_small')
                                            ->label('Описание маленькое')
                                            ->rows(6),
                                        Textarea::make('desc')
                                            ->rows(6)
                                            ->label('Описание'),
                                    ]),
                                    Grid::make(2)->schema([
                                        Textarea::make('proccess')
                                            ->label('Процесс')
                                            ->rows(6),
                                        Textarea::make('result')
                                            ->rows(6)
                                            ->label('Результат'),
                                    ]),

                                ]),
                            Tab::make('Изображения')
                                ->schema([
                                    Grid::make(2)->schema([
                                        SpatieMediaLibraryFileUpload::make('pic_main')
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
                                        SpatieMediaLibraryFileUpload::make('pic_proccess')
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
                                    SpatieMediaLibraryFileUpload::make('service_examples')
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
                            Tab::make('Получено от YClients')
                                ->schema([
                                    Grid::make(2)->schema([
                                        Placeholder::make('Название')
                                            ->content(fn(Service $record): string => $record['yc_title']),
                                        Placeholder::make('Категория')
                                            ->content(fn(Service $record): string => $record['yc_category_name'] ?? 'Ничего не получили'),
                                    ]),
                                    Placeholder::make('Коммент')
                                        ->content(fn(Service $record): string => $record['yc_comment']),
                                    Grid::make(5)->schema([
                                        Placeholder::make("yc_id")
                                            ->content(fn(Service $record): string => $record['yc_id']),
                                        Placeholder::make('Цена_MIN')
                                            ->content(fn(Service $record): string => $record['yc_price_min']),
                                        Placeholder::make('Цена MAX')
                                            ->content(fn(Service $record): string => $record['yc_price_max']),
                                        Placeholder::make('Длительность')
                                            ->content(fn(Service $record): string => $record['yc_duration']),
                                        Placeholder::make('Есть в филиале на Авиаторов')
                                            ->label('Есть в филиале 1')
                                            ->content(fn(Service $record): string => $record['flg_comp_1'] ? 'да' : 'нет'),
                                        Placeholder::make('Есть в филиале Бограда')
                                            ->label('Есть в филиале 2')
                                            ->content(fn(Service $record): string => $record['flg_comp_2'] ? 'да' : 'нет'),
                                    ]),
                                ]),
                            Tab::make('Допы к этой услуге')
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
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('yc_id')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('flg_active')
                    ->label('Активно?')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Название для сайта')
                    ->searchable(),
                TextColumn::make('yc_category_name')
                    ->searchable()
                    ->label('YC Категория')
                    ->sortable(),
                TextColumn::make('scope.name')
                    ->searchable()
                    ->label('Сфера')
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->label('Категория')
                    ->sortable(),
                TextColumn::make('group.name')
                    ->searchable()
                    ->label('Группа')
                    ->sortable(),
                TextColumn::make('service_type.name')
                    ->label('Тип')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('scope_id')
                    ->label('Сфера')
                    ->relationship('scope', 'name'),
                SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name'),
                SelectFilter::make('group_id')
                    ->label('Группа')
                    ->relationship('group', 'name'),
                SelectFilter::make('yc_category_name')
                    ->attribute('yc_category_name')
                    ->options(Service::all()->whereNotNull('yc_category_name')->pluck('yc_category_name', 'yc_category_name')->unique())
                    ->label('YC Категория'),
            ])->filtersFormColumns(2)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
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
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }

}

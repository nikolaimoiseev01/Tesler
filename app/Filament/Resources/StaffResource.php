<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\StaffResource\Pages\ListStaff;
use App\Filament\Resources\StaffResource\Pages\CreateStaff;
use App\Filament\Resources\StaffResource\Pages\EditStaff;
use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\ShopSet;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Сотрудники';

    protected static string | \UnitEnum | null $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Общее')
                            ->schema([
                                Grid::make(2)->schema([
                                    Textarea::make('desc_small')
                                        ->label('Описание маленькое')
                                        ->required()
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Небольшое описание в шапке страницы сотрудника')
                                        ->rows(4)->columnSpan(1),
                                    Textarea::make('desc')
                                        ->rows(4)
                                        ->required()
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Чуть более подробное описание в первом блоке сразу после шапки')
                                        ->label('Описание')->columnSpan(1),
                                    Grid::make(1)->schema([
                                        Toggle::make('flg_active')
                                            ->label('Есть на сайте')
                                            ->inline(false)
                                            ->columnSpan(1)
                                            ->required(),
                                        TextInput::make('experience')
                                            ->required()
                                            ->label('Опыт')
                                            ->maxLength(255)
                                            ->default('1 год'),
                                    ])->columnSpan(1),
                                ])->columns(3),
//                                Forms\Components\Grid::make(3)->schema([
//                                    Select::make('selected_shopset')
//                                        ->label('Шопсет в подборке')
//                                        ->options(ShopSet::all()->pluck('title', 'id'))
//                                        ->searchable()
//                                        ->required(),
//                                    Select::make('selected_sert')
//                                        ->label('Сертификат в подборке')
//                                        ->options(Good::whereJsonContains('good_category_id', 6)->pluck('name', 'id'))
//                                        ->searchable()
//                                        ->required(),
//                                    Select::make('selected_abon')
//                                        ->label('Абонемент в подборке')
//                                        ->options(Good::whereJsonContains('good_category_id', 7)->pluck('name', 'id'))
//                                        ->searchable()
//                                        ->required()
//                                ]),
                            ]),
                        Tab::make('Получено от YClients')
                            ->schema([
                                Placeholder::make('Название')
                                    ->label('YD ID')
                                    ->content(fn(Staff $record): string => $record['yc_id']),
                                Placeholder::make('Имя')
                                    ->content(fn(Staff $record): string => $record['yc_name']),
                                Placeholder::make('Ав')
                                    ->content(fn(Staff $record): string => $record['yc_avatar']),
                                Placeholder::make('Название')
                                    ->content(fn(Staff $record): string => $record['yc_specialization']),
                                Placeholder::make('Название')
                                    ->content(fn(Staff $record): string => $record['yc_position']),
                            ]),
                        Tab::make('Примеры мастера')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('examples')
                                    ->collection('staff_examples')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->label('')
                                    ->imageEditor()
                                    ->panelLayout('grid')
                                    ->imageEditorMode(2)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('11:16')
                                    ->columnSpan(['lg' => 1]),
                            ]),
                        Tab::make('Коллеги мастера')->schema([
                            Section::make([
                                Repeater::make('collegues')
                                    ->simple(
                                        Select::make('staff_id')
                                            ->label('')
                                            ->options(Staff::all()->pluck('yc_name', 'id'))
                                            ->searchable()
                                            ->required()
                                    )
                                    ->label('')
                                    ->addAction(
                                        fn(Action $action) => $action->label('Добавить коллегу'),
                                    )
                                    ->grid(4)
                            ])
                        ])
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('yc_id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                ImageColumn::make('yc_avatar')
                    ->label('Аватар')
                    ->circular(),
                TextColumn::make('yc_name')
                    ->label('Имя')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('yc_specialization')
                    ->label('Специализация YC')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('yc_position')
                    ->sortable()
                    ->label('Позиция YC')
                    ->searchable(),
                ToggleColumn::make('flg_active')
                    ->sortable()
                    ->label('Есть на сайте?')
            ])
            ->filters([
                SelectFilter::make('yc_name')
                    ->options(Staff::all()->pluck('yc_name', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->attribute('id')
                    ->label('Имя'),

                SelectFilter::make('yc_specialization')
                    ->options(Staff::all()->pluck('yc_specialization', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('Специализация YC'),
                SelectFilter::make('yc_position')
                    ->options(Staff::all()->pluck('yc_position', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('Позиция YC'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListStaff::route('/'),
            'create' => CreateStaff::route('/create'),
            'edit' => EditStaff::route('/{record}/edit'),
        ];
    }
}

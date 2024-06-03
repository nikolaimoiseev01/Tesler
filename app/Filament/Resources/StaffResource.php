<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\ShopSet;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Сотрудники';

    protected static ?string $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Общее')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\Textarea::make('desc_small')
                                        ->label('Описание маленькое')
                                        ->required()
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Небольшое описание в шапке страницы сотрудника')
                                        ->rows(4)->columnSpan(1),
                                    Forms\Components\Textarea::make('desc')
                                        ->rows(4)
                                        ->required()
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Чуть более подробное описание в первом блоке сразу после шапки')
                                        ->label('Описание')->columnSpan(1),
                                    Forms\Components\Grid::make(1)->schema([
                                        Forms\Components\Toggle::make('flg_active')
                                            ->label('Есть на сайте')
                                            ->inline(false)
                                            ->columnSpan(1)
                                            ->required(),
                                        Forms\Components\TextInput::make('experience')
                                            ->required()
                                            ->label('Опыт')
                                            ->maxLength(255)
                                            ->default('1 год'),
                                    ])->columnSpan(1),
                                ])->columns(3),
                                Forms\Components\Grid::make(3)->schema([
                                    Select::make('selected_shopset')
                                        ->label('Шопсет в подборке')
                                        ->options(ShopSet::all()->pluck('title', 'id'))
                                        ->searchable()
                                        ->required(),
                                    Select::make('selected_sert')
                                        ->label('Сертификат в подборке')
                                        ->options(Good::whereJsonContains('good_category_id', 6)->pluck('name', 'id'))
                                        ->searchable()
                                        ->required(),
                                    Select::make('selected_abon')
                                        ->label('Абонемент в подборке')
                                        ->options(Good::whereJsonContains('good_category_id', 7)->pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                ]),
                            ]),
                        Tabs\Tab::make('Получено от YClients')
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
                        Tabs\Tab::make('Примеры мастера')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('examples')
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
                        Tabs\Tab::make('Коллеги мастера')->schema([
                            Forms\Components\Card::make([
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
                Tables\Columns\TextColumn::make('yc_id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                ImageColumn::make('yc_avatar')
                    ->label('Аватар')
                    ->circular(),
                Tables\Columns\TextColumn::make('yc_name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yc_specialization')
                    ->label('Специализация YC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yc_position')
                    ->label('Позиция YC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flg_active')
                    ->badge()
                    ->label('Есть на сайте?')
                    ->getStateUsing(function (Model $record) {
                        return $record['flg_active'] == 1 ? 'Есть на сайте' : 'Скрыто';
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Есть на сайте' => 'success',
                        'Скрыто' => 'warning'
                    })
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('yc_name')
                    ->options(Staff::all()->pluck('yc_name', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->attribute('id')
                    ->label('Имя'),

                Tables\Filters\SelectFilter::make('yc_specialization')
                    ->options(Staff::all()->pluck('yc_specialization', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('Специализация YC'),
                Tables\Filters\SelectFilter::make('yc_position')
                    ->options(Staff::all()->pluck('yc_position', 'id')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('Позиция YC'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}

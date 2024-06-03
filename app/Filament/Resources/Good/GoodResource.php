<?php

namespace App\Filament\Resources\Good;

use App\Filament\Resources\Good\GoodResource\Pages;
use App\Filament\Resources\Good\GoodResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\Good_hair_type;
use App\Models\Good\Good_skin_type;
use App\Models\Good\GoodCategory;
use App\Models\Good\GoodType;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GoodResource extends Resource
{
    protected static ?string $model = Good::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Товары';
    protected static ?string $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Общее')
                            ->schema([
                                Forms\Components\Grid::make()->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->label('Название')
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Название исключительно для сайта')
                                        ->columnSpan(5)
                                        ->maxLength(255),
                                    Forms\Components\Toggle::make('flg_big_block')
                                        ->label('Большой блок')
                                        ->inline(false)
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Если выбрано, то в сетке товаров этот товар будет большим блоком')
                                        ->columnSpan(2)
                                        ->required(),
                                    Forms\Components\Toggle::make('flg_active')
                                        ->label('Есть на сайте')
                                        ->inline(false)
                                        ->columnSpan(1)
                                        ->required(),
                                ])->columns(8),

                                Section::make('Категории товара')->schema([
                                    Repeater::make('service_adds')
                                        ->simple(
                                            Forms\Components\Select::make('good_category_id')
                                                ->options(GoodCategory::all()->pluck('title', 'id'))
                                                ->searchable()
                                                ->label('Категория товара'),
                                        )
                                        ->label('')
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить категорию'),
                                        )
                                        ->grid(2)
                                ])->collapsed(),

                                Section::make('Типы кожи и волос')->schema([
                                    Repeater::make('skin_type')
                                        ->simple(
                                            Forms\Components\Select::make('skin_type')
                                                ->options(Good_skin_type::all()->pluck('title', 'id'))
                                                ->searchable()
                                                ->label('Тип кожи'),
                                        )
                                        ->label('')
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить тип кожи'),
                                        )
                                        ->grid(2),
                                    Repeater::make('hair_type')
                                        ->label('Тип волос')
                                        ->simple(
                                            Forms\Components\Select::make('hair_type')
                                                ->options(Good_hair_type::all()->pluck('title', 'id'))
                                                ->searchable()
                                                ->label('Тип волос'),
                                        )
                                        ->label('')
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить тип волос'),
                                        )
                                        ->grid(2)
                                ])->collapsed(),

                                Section::make('Общие тексты')->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\Select::make('good_type_id')
                                            ->options(GoodType::all()->pluck('title', 'id'))
                                            ->searchable()
                                            ->label('Тип товара'),
                                        Forms\Components\TextInput::make('promo_text')
                                            ->label('Промо-текст')
                                            ->hintIcon('heroicon-o-question-mark-circle')
                                            ->hintIconTooltip('Если заполнен, то у карточки товара появляется бейджик с этим текстом')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('discount')
                                            ->label('Скидка в процентах')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('brand')
                                            ->label('Бренд')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('capacity')
                                            ->label('Объем')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('capacity_type')
                                            ->label('Тип измерения объема')
                                            ->maxLength(255),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Textarea::make('desc_small')
                                            ->label('Описание маленькое')
                                            ->required()
                                            ->rows(4),
                                        Forms\Components\Textarea::make('desc')
                                            ->rows(4)
                                            ->required()
                                            ->label('Описание'),
                                    ]),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Textarea::make('usage')
                                            ->label('Использование')
                                            ->required()
                                            ->rows(4),
                                        Forms\Components\Textarea::make('compound')
                                            ->rows(4)
                                            ->required()
                                            ->label('Состав'),
                                    ]),
                                ])->collapsed(),

                                Section::make('Связь с услугами')
                                    ->schema([
                                        Forms\Components\Grid::make()->schema([
                                            Forms\Components\Select::make('scope_id')
                                                ->relationship(name: 'scope', titleAttribute: 'name')
                                                ->label('Сфера от услуг'),
                                            Forms\Components\Select::make('category_id')
                                                ->relationship(name: 'category', titleAttribute: 'name')
                                                ->label('Категория от услуг'),
                                        ])
                                    ])->collapsible()->collapsed(),

                                Section::make('Специальные характеристики')->schema([
                                    Repeater::make('specs_detailed')
                                        ->label('')
                                        ->schema([
                                            TextInput::make('title')->required(),
                                            TextInput::make('value')->required(),
                                        ])
                                        ->columns(2)
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить'),
                                        )
                                        ->grid(2)
                                ])->collapsed(),
                            ]),

                        Tabs\Tab::make('Yclients')
                            ->label('Получено из YClients')
                            ->schema([
                                Forms\Components\Grid::make()->schema([
                                    Placeholder::make('yc_id')
                                        ->label('YC ID')
                                        ->content(fn(Good $record): string => $record['yc_id']),
                                    Placeholder::make('yc_title')
                                        ->label('Название')
                                        ->content(fn(Good $record): string => $record['yc_title']),
                                    Placeholder::make('yc_category')
                                        ->label('Категория')
                                        ->content(fn(Good $record): string => $record['yc_category']),
                                    Placeholder::make('yc_price')
                                        ->label('Цена')
                                        ->content(fn(Good $record): string => $record['yc_price']),
                                ])
                            ]),
                        Tabs\Tab::make('Изображения')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('good_examples')
                                    ->collection('good_examples')
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
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('yc_id')
                    ->label('YC ID'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yc_category')
                    ->label('Категория из YClients')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yc_price')
                    ->numeric()
                    ->label('Цена')
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
                Tables\Columns\TextColumn::make('capacity')
                    ->label('Объем')
                    ->getStateUsing(function (Model $record) {
                        return $record['capacity'] . ' ' . $record['capacity_type'];
                    })
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('goodtype.title')
                    ->label('Тип товара')
                    ->searchable(),
                Tables\Columns\TextColumn::make('yc_actual_amount')
                    ->label('Остаток из YClients')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListGoods::route('/'),
            'create' => Pages\CreateGood::route('/create'),
            'edit' => Pages\EditGood::route('/{record}/edit'),
        ];
    }
}

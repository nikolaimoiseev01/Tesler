<?php

namespace App\Filament\Resources\Good;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Good\GoodResource\Pages\ListGoods;
use App\Filament\Resources\Good\GoodResource\Pages\CreateGood;
use App\Filament\Resources\Good\GoodResource\Pages\EditGood;
use App\Filament\Resources\Good\GoodResource\Pages;
use App\Filament\Resources\Good\GoodResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\Good_hair_type;
use App\Models\Good\Good_skin_type;
use App\Models\Good\GoodCategory;
use App\Models\Good\GoodType;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class GoodResource extends Resource
{
    protected static ?string $model = Good::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Товары';
    protected static string | \UnitEnum | null $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Общее')
                            ->schema([
                                Grid::make()->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->label('Название')
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Название исключительно для сайта')
                                        ->columnSpan(5)
                                        ->maxLength(255),
                                    Toggle::make('flg_big_block')
                                        ->label('Большой блок')
                                        ->inline(false)
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('Если выбрано, то в сетке товаров этот товар будет большим блоком')
                                        ->columnSpan(2)
                                        ->required(),
                                    Toggle::make('flg_active')
                                        ->label('Есть на сайте')
                                        ->inline(false)
                                        ->columnSpan(1)
                                        ->required(),
                                ])->columns(8),

                                Section::make('Категории товара')->schema([
                                    Repeater::make('good_category_id')
                                        ->simple(
                                            Select::make('good_category_id')
                                                ->options(GoodCategory::all()->pluck('title', 'id'))
                                                ->searchable()
                                                ->dehydrateStateUsing(fn(string $state): string => intval($state))
                                                ->label('Категория товара'),
                                        )
                                        ->required()
                                        ->label('')
                                        ->mutateDehydratedStateUsing(function (array $state): array {
                                            $intConverted = array_values(array_map(fn($item) => (int)$item['good_category_id'], $state));
                                            return $intConverted;
                                        }
                                        )
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить категорию'),
                                        )
                                        ->grid(2)
                                ])->collapsed(),

                                Section::make('Типы кожи и волос')->schema([
                                    Repeater::make('skin_type')
                                        ->simple(
                                            Select::make('skin_type')
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
                                            Select::make('hair_type')
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
                                    Grid::make(3)->schema([
                                        Select::make('good_type_id')
                                            ->options(GoodType::all()->pluck('title', 'id'))
                                            ->searchable()
                                            ->label('Тип товара'),
                                        TextInput::make('promo_text')
                                            ->label('Промо-текст')
                                            ->hintIcon('heroicon-o-question-mark-circle')
                                            ->hintIconTooltip('Если заполнен, то у карточки товара появляется бейджик с этим текстом')
                                            ->maxLength(255),
                                        TextInput::make('discount')
                                            ->label('Скидка в процентах')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                    Grid::make(3)->schema([
                                        TextInput::make('brand')
                                            ->label('Бренд')
                                            ->maxLength(255),
                                        TextInput::make('capacity')
                                            ->label('Объем')
                                            ->numeric(),
                                        TextInput::make('capacity_type')
                                            ->label('Тип измерения объема')
                                            ->maxLength(255),
                                    ]),

                                    Grid::make(2)->schema([
                                        Textarea::make('desc_small')
                                            ->label('Описание маленькое')
                                            ->required()
                                            ->rows(4),
                                        Textarea::make('desc')
                                            ->rows(4)
                                            ->required()
                                            ->label('Описание'),
                                    ]),
                                    Grid::make(2)->schema([
                                        Textarea::make('usage')
                                            ->label('Использование')
                                            ->required()
                                            ->rows(4),
                                        Textarea::make('compound')
                                            ->rows(4)
                                            ->required()
                                            ->label('Состав'),
                                    ]),
                                ])->collapsed(),

                                Section::make('Связь с услугами')
                                    ->schema([
                                        Grid::make()->schema([
                                            Select::make('scope_id')
                                                ->relationship(name: 'scope', titleAttribute: 'name')
                                                ->label('Сфера от услуг'),
                                            Select::make('category_id')
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

                        Tab::make('Yclients')
                            ->label('Получено из YClients')
                            ->schema([
                                Grid::make()->schema([
                                    Placeholder::make('yc_ids')
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('В каждом салоне свой ID')
                                        ->label('YC ID')
                                        ->content(fn(Good $record): string => $record['yc_ids']),
                                    Placeholder::make('yc_actual_amount')
                                        ->hintIcon('heroicon-o-question-mark-circle')
                                        ->hintIconTooltip('В каждом салоне свой ID')
                                        ->label('Остатки на разных складах')
                                        ->content(function (Good $record) {
                                            $string = '';
                                            foreach (json_decode($record['yc_actual_amount']) as $item) {
                                                $string .= "Филиал: $item->name, Склад: $item->storage_id, Остаток: $item->amount<br>";
                                            }
                                            return new HtmlString($string);
                                        }),
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
                            ])
                        ,
                        Tab::make('Изображения')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('good_examples')
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
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->label('Название')
                    ->limit(50)
                    ->tooltip(fn(Good $record): string => $record['name'])
                    ->searchable(),
                TextColumn::make('yc_category')
                    ->label('Категория из YClients')
                    ->searchable(),
                TextColumn::make('yc_price')
                    ->numeric()
                    ->label('Цена')
                    ->sortable(),
                TextColumn::make('flg_active')
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
                TextColumn::make('goodtype.title')
                    ->label('Тип товара')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('yc_actual_amount_total')
                    ->tooltip('На всех складах')
                    ->label('Остаток из YClients')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('yc_category')
                    ->options(Good::all()->pluck('yc_category', 'yc_category')->unique())
                    ->multiple()
                    ->searchable()
                    ->label('YC Категория'),
                SelectFilter::make('flg_active')
                    ->options(Good::all()->pluck('flg_active', 'flg_active')->unique())
                    ->multiple()
                    ->label('Активно')
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
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
            'index' => ListGoods::route('/'),
            'create' => CreateGood::route('/create'),
            'edit' => EditGood::route('/{record}/edit'),
        ];
    }
}

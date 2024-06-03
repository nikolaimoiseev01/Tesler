<?php

namespace App\Filament\Resources\Good;

use App\Filament\Resources\Good\OrderResource\Pages;
use App\Filament\Resources\Good\OrderResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\GoodCategory;
use App\Models\Good\Order;
use App\Models\Good_deli_status;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Заказы товаров';
    protected static ?string $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Placeholder::make('price')
                                ->label('Общая стоимость с промокодом')
                                ->content(fn(Order $record): string => number_format($record['price'], 2) . ' руб.'),
                            Placeholder::make('promocode')
                                ->label('Промокод')
                                ->content(fn(Order $record): string => $record['promocode'] ?? 'Не использовался'),
                        ]),
                        Placeholder::make('need_delivery')
                            ->label('Доставка')
                            ->content(fn(Order $record): string => $record['need_delivery'] ? 'Нужна' : 'Нет'),
                    ])->columnSpan(1)->heading('Финансы'),
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Placeholder::make('name')
                                ->label('Имя клиента: ')
                                ->content(fn(Order $record): string => $record['name'] . ' ' . $record['surname']),
                            Placeholder::make('mobile')
                                ->label('Телефон')
                                ->content(fn(Order $record): string => $record['mobile']),
                        ]),
                        Placeholder::make('address')
                            ->label('Адрес')
                            ->content(fn(Order $record): string => "{$record['city']}, {$record['address']}, {$record['index']}"),
                    ])->columnSpan(1)->heading('Клиент')
                ])->columns(2),
                Forms\Components\Grid::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Placeholder::make('goods')
                            ->label('')
                            ->content(function (Order $record): HtmlString {
                                $goods = [];
                                foreach (json_decode($record['goods']) as $key => $good) {
                                    $good_found = Good::where('id', $good->good_id)->first();
                                    $good_string = "<b>{$good->amount} шт.:</b> <a style='color: blue' target='_blank' href='/admin/good/goods/{$good_found['id']}/edit'>{$good_found['name']}</a>";
                                    array_push($goods, $key + 1 . ') ' . $good_string);
                                }
                                $goods = implode('<br>', $goods);
                                return new HtmlString($goods);
                            }),
                    ])->columnSpan(2)->heading('Товары в заказе'),
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Placeholder::make('tinkoff_order_id')
                                ->label('Tinkoff Order ID')
                                ->content(fn(Order $record): string => $record['tinkoff_order_id']),
                            Placeholder::make('tinkoff_status')
                                ->label('Tinkoff Status')
                                ->content(fn(Order $record): string => $record['tinkoff_status']),
                        ]),
                    ])->columnSpan(2)->heading('От Tinkoff'),
                ])->columns(4),

                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Select::make('good_deli_status_id')
                            ->options(Good_deli_status::all()->pluck('title', 'id'))
                            ->label('Статус доставки'),
                        Forms\Components\TextInput::make('good_deli_price')
                            ->label('Стоимость доставки')
                            ->numeric(),
                        Forms\Components\TextInput::make('good_deli_track_number')
                            ->label('Трек-номер')
                            ->maxLength(255),
                    ])
                ])->heading('Доставка')->hidden(fn(Get $get): bool => !$get('need_delivery')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tinkoff_order_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tinkoff Order ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tinkoff_status')
                    ->label('Статус Tinkoff')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Сумма заказа')
                    ->numeric(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя клиента')
                    ->getStateUsing(function (Model $record) {
                        return $record['name'] . ' ' . $record['surname'];
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->label('Телефон')
                    ->searchable(),
                Tables\Columns\TextColumn::make('need_delivery')
                    ->badge()
                    ->getStateUsing(function (Model $record) {
                        return $record['need_delivery'] == 1 ? 'Да' : 'Нет';
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Да' => 'success',
                        'Нет' => 'warning'
                    })
                    ->label('Доставка?')
                    ->sortable(),
                Tables\Columns\TextColumn::make('good_deli_status.title')
                    ->label('Статус доставки')
                    ->default('Ну нужна')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('promocode')
                    ->label('Промокод')
                    ->default('Не спользовался')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

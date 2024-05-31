<?php

namespace App\Filament\Resources\Good;

use App\Filament\Resources\Good\ShopSetResource\Pages;
use App\Filament\Resources\Good\ShopSetResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\Good_hair_type;
use App\Models\Good\GoodCategory;
use App\Models\Good\ShopSet;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShopSetResource extends Resource
{
    protected static ?string $model = ShopSet::class;

    protected static ?string $navigationLabel = 'Шопсеты';
    protected static ?string $navigationGroup = 'Модель товаров';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('staff_id')
                            ->options(Staff::all()->pluck('yc_name', 'id'))
                            ->searchable()
                            ->label('Сотрудник'),
                    ]),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('pic_shopset')
                        ->collection('pic_shopset')
                        ->image()
                        ->label('')
                        ->imageEditor()
                        ->panelLayout('grid')
                        ->imageEditorMode(2)
                        ->imageResizeMode('cover')
                        ->label('Примеры')
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('1080')
                        ->imageResizeTargetHeight('1080')
                        ->columnSpan(['lg' => 1]),
                    Forms\Components\Section::make('Товары в шопсете')->schema([
                        Repeater::make('goods')
                            ->simple(
                                Forms\Components\Select::make('good_id')
                                    ->options(Good::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->label('Товар'),
                            )
                            ->label('')
                            ->addAction(
                                fn(Action $action) => $action->label('Добавить товар в шопсет'),
                            )
                    ])->collapsed()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('pic_shopset')
                    ->label('Обложка')
                    ->getStateUsing(function (Model $record) {
                        return $record->getFirstMediaUrl('pic_shopset');
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('staff.yc_name')
                    ->label('Сотрудник')
                    ->getStateUsing(function (Model $record) {
                        return $record->staff['yc_name'] ?? 'Не установлен';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('goods')
                    ->label('Товаров в шопсете')
                    ->getStateUsing(function (Model $record) {
                        $goods_sum = Good::whereIn('id', $record['goods'] ?? [])->sum('yc_price');
                        return count($record['goods'] ?? []) . 'шт. на ' . number_format($goods_sum, 0) . 'руб.';
                    })
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
            'index' => Pages\ListShopSets::route('/'),
            'create' => Pages\CreateShopSet::route('/create'),
            'edit' => Pages\EditShopSet::route('/{record}/edit'),
        ];
    }
}

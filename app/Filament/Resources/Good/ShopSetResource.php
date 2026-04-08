<?php

namespace App\Filament\Resources\Good;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Good\ShopSetResource\Pages\ListShopSets;
use App\Filament\Resources\Good\ShopSetResource\Pages\CreateShopSet;
use App\Filament\Resources\Good\ShopSetResource\Pages\EditShopSet;
use App\Filament\Resources\Good\ShopSetResource\Pages;
use App\Filament\Resources\Good\ShopSetResource\RelationManagers;
use App\Models\Good\Good;
use App\Models\Good\Good_hair_type;
use App\Models\Good\GoodCategory;
use App\Models\Good\ShopSet;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
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
    protected static string | \UnitEnum | null $navigationGroup = 'Модель товаров';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),
                        Select::make('staff_id')
                            ->options(Staff::all()->pluck('yc_name', 'id'))
                            ->searchable()
                            ->label('Сотрудник'),
                    ]),
                    SpatieMediaLibraryFileUpload::make('pic_shopset')
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
                    Section::make('Товары в шопсете')->schema([
                        Repeater::make('goods')
                            ->simple(
                                Select::make('good_id')
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
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                ImageColumn::make('pic_shopset')
                    ->label('Обложка')
                    ->getStateUsing(function (Model $record) {
                        return $record->getFirstMediaUrl('pic_shopset');
                    }),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('staff.yc_name')
                    ->label('Сотрудник')
                    ->getStateUsing(function (Model $record) {
                        return $record->staff['yc_name'] ?? 'Не установлен';
                    })
                    ->sortable(),
                TextColumn::make('goods')
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
            'index' => ListShopSets::route('/'),
            'create' => CreateShopSet::route('/create'),
            'edit' => EditShopSet::route('/{record}/edit'),
        ];
    }
}

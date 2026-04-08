<?php

namespace App\Filament\Resources\Good;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Good\PromocodeResource\Pages\ManagePromocodes;
use App\Filament\Resources\Good\PromocodeResource\Pages;
use App\Filament\Resources\Good\PromocodeResource\RelationManagers;
use App\Models\Good\Promocode;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromocodeResource extends Resource
{
    protected static ?string $model = Promocode::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationLabel = 'Промокоды';
    protected static string | \UnitEnum | null $navigationGroup = 'Модель товаров';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Промокод')
                    ->required()
                    ->maxLength(255),
                TextInput::make('discount')
                    ->label('Скидка в процентах')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Промокод')
                    ->searchable(),
                TextColumn::make('discount')
                    ->numeric()
                    ->label('Скидка в процентах')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePromocodes::route('/'),
        ];
    }
}

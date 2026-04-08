<?php

namespace App\Filament\Resources\Calculators;

use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Calculators\CalcCosmeticResource\Pages\ManageCalcCosmetics;
use App\Filament\Resources\Calculators\CalcCosmeticResource\Pages;
use App\Filament\Resources\Calculators\CalcCosmeticResource\RelationManagers;
use App\Models\Calculators\CalcCosmetic;
use App\Models\Service\Service;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalcCosmeticResource extends Resource
{
    protected static ?string $model = CalcCosmetic::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Косметология';
    protected static string | \UnitEnum | null $navigationGroup = 'Калькуляторы';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('step_1')->visible(fn($context) => $context === 'create'),
                TextInput::make('step_2')->visible(fn($context) => $context === 'create'),
                TextInput::make('step_3')->visible(fn($context) => $context === 'create'),
                Repeater::make('services')
                    ->simple(
                        Select::make('name')
                            ->options(Service::all()->pluck('name', 'id')->unique())
                            ->searchable()
                            ->required(),
                    )->columnSpanFull()
                    ->label('Услуги для этого варианта исхода')
                    ->addAction(
                        fn(Action $action) => $action->label('Добавить услугу'),
                    )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('step_1')
                    ->label('Шаг 1'),
                TextColumn::make('step_2')
                    ->label('Шаг 2'),
                TextColumn::make('step_3')
                    ->label('Шаг 3'),
            ])
            ->filters([
                SelectFilter::make('step_1')
                    ->options(CalcCosmetic::all()->pluck('step_1', 'step_1')->unique())
                    ->searchable()
                    ->label('Шаг 1'),
                SelectFilter::make('step_2')
                    ->options(CalcCosmetic::all()->pluck('step_2', 'step_2')->unique())
                    ->searchable()
                    ->label('Шаг 2'),
                SelectFilter::make('step_3')
                    ->options(CalcCosmetic::all()->pluck('step_3', 'step_3')->unique())
                    ->searchable()
                    ->label('Шаг 3'),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCalcCosmetics::route('/'),
        ];
    }
}

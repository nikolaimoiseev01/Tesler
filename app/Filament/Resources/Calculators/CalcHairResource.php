<?php

namespace App\Filament\Resources\Calculators;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Calculators\CalcHairResource\Pages\ManageCalcHairs;
use App\Filament\Resources\Calculators\CalcHairResource\Pages;
use App\Filament\Resources\Calculators\CalcHairResource\RelationManagers;
use App\Models\Calculators\CalcCosmetic;
use App\Models\Calculators\CalcHair;
use App\Models\Good\GoodCategory;
use App\Models\Service\Service;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalcHairResource extends Resource
{
    protected static ?string $model = CalcHair::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Окрашивание';
    protected static string | \UnitEnum | null $navigationGroup = 'Калькуляторы';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()->schema([
                    TextInput::make('step_1')
                        ->label('Шаг 1')
                        ->disabled(),
                    TextInput::make('step_2')
                        ->label('Шаг 2')
                        ->disabled(),
                    TextInput::make('step_3')
                        ->label('Шаг 3')
                        ->disabled(),
                ])->columns(3),
                Select::make('service_id')
                    ->options(Service::all()->pluck('name', 'id'))
                    ->searchable()
                    ->columnSpanFull()
                    ->label('Услуга для этого варианта'),
                TextInput::make('result_price')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
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
                TextColumn::make('result_price')
                    ->label('Цена'),
                TextColumn::make('service.name')
                    ->label('Услуга')
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('step_1')
                    ->options(CalcHair::all()->pluck('step_1', 'step_1')->unique())
                    ->searchable()
                    ->label('Шаг 1'),
                SelectFilter::make('step_2')
                    ->options(CalcHair::all()->pluck('step_2', 'step_2')->unique())
                    ->searchable()
                    ->label('Шаг 2'),
                SelectFilter::make('step_3')
                    ->options(CalcHair::all()->pluck('step_3', 'step_3')->unique())
                    ->searchable()
                    ->label('Шаг 3'),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCalcHairs::route('/'),
        ];
    }
}

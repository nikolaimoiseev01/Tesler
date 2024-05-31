<?php

namespace App\Filament\Resources\Calculators;

use App\Filament\Resources\Calculators\CalcHairResource\Pages;
use App\Filament\Resources\Calculators\CalcHairResource\RelationManagers;
use App\Models\Calculators\CalcCosmetic;
use App\Models\Calculators\CalcHair;
use App\Models\Good\GoodCategory;
use App\Models\Service\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalcHairResource extends Resource
{
    protected static ?string $model = CalcHair::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Окрашивание';
    protected static ?string $navigationGroup = 'Калькуляторы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->schema([
                    Forms\Components\TextInput::make('step_1')
                        ->label('Шаг 1')
                        ->disabled(),
                    Forms\Components\TextInput::make('step_2')
                        ->label('Шаг 2')
                        ->disabled(),
                    Forms\Components\TextInput::make('step_3')
                        ->label('Шаг 3')
                        ->disabled(),
                ])->columns(3),
                Forms\Components\Select::make('service_id')
                    ->options(Service::all()->pluck('name', 'id'))
                    ->searchable()
                    ->columnSpanFull()
                    ->label('Услуга для этого варианта'),
                Forms\Components\TextInput::make('result_price')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('step_1')
                    ->label('Шаг 1'),
                Tables\Columns\TextColumn::make('step_2')
                    ->label('Шаг 2'),
                Tables\Columns\TextColumn::make('step_3')
                    ->label('Шаг 3'),
                Tables\Columns\TextColumn::make('result_price')
                    ->label('Цена'),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Услуга')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('step_1')
                    ->options(CalcHair::all()->pluck('step_1', 'step_1')->unique())
                    ->searchable()
                    ->label('Шаг 1'),
                Tables\Filters\SelectFilter::make('step_2')
                    ->options(CalcHair::all()->pluck('step_2', 'step_2')->unique())
                    ->searchable()
                    ->label('Шаг 2'),
                Tables\Filters\SelectFilter::make('step_3')
                    ->options(CalcHair::all()->pluck('step_3', 'step_3')->unique())
                    ->searchable()
                    ->label('Шаг 3'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCalcHairs::route('/'),
        ];
    }
}

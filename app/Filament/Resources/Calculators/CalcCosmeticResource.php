<?php

namespace App\Filament\Resources\Calculators;

use App\Filament\Resources\Calculators\CalcCosmeticResource\Pages;
use App\Filament\Resources\Calculators\CalcCosmeticResource\RelationManagers;
use App\Models\Calculators\CalcCosmetic;
use App\Models\Service\Service;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalcCosmeticResource extends Resource
{
    protected static ?string $model = CalcCosmetic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Косметология';
    protected static ?string $navigationGroup = 'Калькуляторы';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('step_1')
                    ->label('Шаг 1'),
                Tables\Columns\TextColumn::make('step_2')
                    ->label('Шаг 2'),
                Tables\Columns\TextColumn::make('step_3')
                    ->label('Шаг 3'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('step_1')
                    ->options(CalcCosmetic::all()->pluck('step_1')->unique())
                    ->searchable()
                    ->label('Шаг 1'),
                Tables\Filters\SelectFilter::make('step_2')
                    ->options(CalcCosmetic::all()->pluck('step_2')->unique())
                    ->searchable()
                    ->label('Шаг 2'),
                Tables\Filters\SelectFilter::make('step_3')
                    ->options(CalcCosmetic::all()->pluck('step_3')->unique())
                    ->searchable()
                    ->label('Шаг 3'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCalcCosmetics::route('/'),
        ];
    }
}

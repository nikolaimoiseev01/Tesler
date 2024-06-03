<?php

namespace App\Filament\Resources\Service;

use App\Filament\Resources\Service\GroupResource\Pages;
use App\Filament\Resources\Service\GroupResource\RelationManagers;
use App\Models\Service\Group;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Группы';
    protected static ?string $navigationGroup = 'Модель услуг';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->label('Название')
                    ->maxLength(255),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('scope_id')
                        ->relationship(name: 'scope', titleAttribute: 'name')
                        ->label('Сфера')
                        ->required(),
                    Forms\Components\Select::make('category_id')
                        ->relationship(name: 'category', titleAttribute: 'name')
                        ->label('Категория')
                        ->required(),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scope.name')
                    ->label('Сфера')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Позиция')
                    ->sortable(),
                TextColumn::make('service_count')->counts('service')->label('Услуг в группе')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('scope_id')
                    ->label('Сфера')
                    ->relationship('scope', 'name'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
            ])
            ->defaultSort(fn ($query) => $query->orderBy('scope_id', 'asc')->orderBy('position', 'asc'))
            ->reorderable('position')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGroups::route('/'),
        ];
    }
}

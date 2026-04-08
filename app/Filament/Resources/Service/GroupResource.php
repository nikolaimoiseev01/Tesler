<?php

namespace App\Filament\Resources\Service;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use App\Filament\Resources\Service\GroupResource\Pages\ManageGroups;
use App\Filament\Resources\Service\GroupResource\Pages;
use App\Filament\Resources\Service\GroupResource\RelationManagers;
use App\Models\Service\Group;
use Filament\Forms;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Группы';
    protected static string | \UnitEnum | null $navigationGroup = 'Модель услуг';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->label('Название')
                    ->maxLength(255),
                Grid::make(2)->schema([
                    Select::make('scope_id')
                        ->relationship(name: 'scope', titleAttribute: 'name')
                        ->label('Сфера')
                        ->required(),
                    Select::make('category_id')
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
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('scope.name')
                    ->label('Сфера')
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),
                TextColumn::make('position')
                    ->label('Позиция')
                    ->sortable(),
                TextColumn::make('service_count')->counts('service')->label('Услуг в группе')
            ])
            ->filters([
                SelectFilter::make('scope_id')
                    ->label('Сфера')
                    ->relationship('scope', 'name'),
                SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
            ])
            ->defaultSort(fn ($query) => $query->orderBy('scope_id', 'asc')->orderBy('position', 'asc'))
            ->reorderable('position')
            ->recordActions([
                EditAction::make(),
            ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGroups::route('/'),
        ];
    }
}

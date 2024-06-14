<?php

namespace App\Filament\Resources\Service;

use App\Filament\Resources\Service\ScopeResource\Pages;
use App\Filament\Resources\Service\ScopeResource\RelationManagers;
use App\Models\Service\Scope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScopeResource extends Resource
{
    protected static ?string $model = Scope::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Сферы';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Модель услуг';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\TextInput::make('name')
                        ->disabled()
                        ->label('Название')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('desc')
                        ->required()
                        ->label('Описание')
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('flg_active')
                        ->label('Есть на сайте?'),
                ])->columnSpan(3),
                Forms\Components\SpatieMediaLibraryFileUpload::make('main_page_pic')
                    ->collection('main_page_pic')
                    ->label('Обложка на главной странице')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->label('')
                    ->imageEditor()
                    ->imageEditorMode(2)
                    ->imageResizeMode('cover')
                    ->imageResizeTargetHeight(640)
                    ->imageResizeTargetWidth(388)
                    ->imageCropAspectRatio('388:640')
                    ->columnSpan(['lg' => 1]),
                Forms\Components\SpatieMediaLibraryFileUpload::make('scope_page_pic')
                    ->collection('scope_page_pic')
                    ->image()
                    ->label('Обложка на странице сферы')
                    ->multiple()
                    ->reorderable()
                    ->label('')
                    ->imageEditor()
                    ->imageEditorMode(2)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1662:729')
                    ->columnSpan(['lg' => 1]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flg_active')
                    ->badge()
                    ->getStateUsing(function (Model $record) {
                        return $record['flg_active'] == 1 ? 'Есть на сайте' : 'Скрыто';
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Есть на сайте' => 'success',
                        'Скрыто' => 'warning'
                    })
                    ->numeric()
                    ->label('Активно?')
                    ->sortable(),
                TextColumn::make('category_count')->counts('category')->label('Категорий в сфере'),
                TextColumn::make('group_count')->counts('group')->label('Групп в сфере'),
                TextColumn::make('service_count')->counts('service')->label('Услуг в сфере'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ManageScopes::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getWidgets(): array
    {
        return [
            ServiceResource\Widgets\UpdateYC::class,
        ];
    }
}

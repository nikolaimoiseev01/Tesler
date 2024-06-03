<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use App\Models\ConsultStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Консультации';

    protected static ?string $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Консультации';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('consult_status_id', 1)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_name')
                    ->label('Имя пользователя')
                    ->disabled()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_mobile')
                    ->label('Телефон')
                    ->disabled()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_comment')
                    ->label('Вопрос')
                    ->disabled()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Имя клиента')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_mobile')
                    ->label('Телефон')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_comment')
                    ->limit(20)
                    ->label('Комментарий')
                    ->searchable(),
                SelectColumn::make('consult_status_id')
                    ->options(ConsultStatus::all()->pluck('title', 'id'))
                    ->extraAttributes(['class' => 'w-[16]'])
                    ->label('Статус'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m H:i')
                    ->sortable(),
            ])
            ->recordUrl('')
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
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
            'index' => Pages\ManageConsultations::route('/'),
        ];
    }
}

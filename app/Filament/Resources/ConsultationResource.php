<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\ConsultationResource\Pages\ManageConsultations;
use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use App\Models\ConsultStatus;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Консультации';

    protected static string | \UnitEnum | null $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Консультации';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('consult_status_id', 1)->count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_name')
                    ->label('Имя пользователя')
                    ->disabled()
                    ->required()
                    ->maxLength(255),
                TextInput::make('user_mobile')
                    ->label('Телефон')
                    ->disabled()
                    ->required()
                    ->maxLength(255),
                TextInput::make('user_comment')
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
                TextColumn::make('user_name')
                    ->label('Имя клиента')
                    ->searchable(),
                TextColumn::make('user_mobile')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('user_comment')
                    ->limit(20)
                    ->label('Комментарий')
                    ->searchable(),
                SelectColumn::make('consult_status_id')
                    ->options(ConsultStatus::all()->pluck('title', 'id'))
                    ->extraAttributes(['class' => 'w-[16]'])
                    ->label('Статус'),
                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m H:i')
                    ->sortable(),
            ])
            ->recordUrl('')
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
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
            'index' => ManageConsultations::route('/'),
        ];
    }
}

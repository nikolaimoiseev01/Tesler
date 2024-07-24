<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefreshLogResource\Pages;
use App\Filament\Resources\RefreshLogResource\RelationManagers;
use App\Models\RefreshLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class RefreshLogResource extends Resource
{
    protected static ?string $model = RefreshLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'История обновлений';

    protected static ?string $navigationGroup = 'Настройки';

    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
                Grid::make(3)->schema([
                    TextEntry::make('model')
                        ->label('Модель'),
                    TextEntry::make('type')
                        ->label('Тип обновления'),
                    TextEntry::make('created_at')
                        ->dateTime()
                        ->label('Дата'),
                ])->columns(3),
                TextEntry::make('summary')
                    ->columnSpanFull()
                    ->label('Общее описание'),
                Section::make('Подробное описание')->schema([
                    TextEntry::make('description')
                        ->label('')
                        ->formatStateUsing(function (RefreshLog $refreshLog): HtmlString {
                            $array = json_decode($refreshLog['description'], true);
                            $array = collect($array)->sortKeys()->toArray();
                            $html = '';

                            foreach ($array as $group => $values) {

                                $html .= "<div x-data='{ open: false }' class='group'><br><b>{$group}</b> <span @click=\"open = !open\" x-text=\"open ? `Скрыть` : `Подробнее`\"></span><br>";
                                foreach ($values as $key => $elements) {
                                    $html .= "<b x-show='open'>{$key}: yc_id = {$elements['yc_id']}</b>";
                                    foreach ($elements as $key => $value) {
                                        if ($key <> 'yc_id') {
                                            $html .= "<p x-show='open'>{$key} -> {$value}</p>";
                                        }
                                    }
                                }
                                $html .= "</div>";
                            }
                            $html = new HtmlString($html);
                            return $html;
                        })
                        ->columnSpanFull()
                ])->collapsed()

//                Forms\Components\TextInput::make('model')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('type')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('summary')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('description')
//                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->label('Модель')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата процесса')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRefreshLogs::route('/'),
        ];
    }
}

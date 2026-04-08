<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\RefreshLogResource\Pages\ManageRefreshLogs;
use App\Filament\Resources\RefreshLogResource\Pages;
use App\Filament\Resources\RefreshLogResource\RelationManagers;
use App\Models\RefreshLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class RefreshLogResource extends Resource
{
    protected static ?string $model = RefreshLog::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'История обновлений';

    protected static string | \UnitEnum | null $navigationGroup = 'Настройки';

    public static function infolist(Schema $schema): Schema
    {

        return $schema
            ->components([
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
                                    $html .= "<b x-show='open'>{$key}: yc_id (в каждом филиале свой ID) = {$elements['yc_ids']}</b>";
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
                ])

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
                TextColumn::make('model')
                    ->label('Модель')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Дата процесса')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRefreshLogs::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\PromoResource\Pages\ListPromos;
use App\Filament\Resources\PromoResource\Pages\CreatePromo;
use App\Filament\Resources\PromoResource\Pages\EditPromo;
use App\Filament\Resources\PromoResource\Pages;
use App\Filament\Resources\PromoResource\RelationManagers;
use App\Models\Promo;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-m-arrow-trending-up';

    protected static ?string $navigationLabel = 'Промо-акции';

    protected static string | \UnitEnum | null $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Grid::make()->schema([
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('type')
                            ->label('Тип акции')
                            ->maxLength(255),
                    ]),

                    Grid::make()->schema([
                        Textarea::make('desc')
                            ->label('Описание')
                            ->required()
                            ->rows(5)
                            ->columnSpan(1),
                        Grid::make()->schema([
                            TextInput::make('link')
                                ->label('Куда ведет ссылка')
                                ->maxLength(255),
                            TextInput::make('link_text')
                                ->label('Текст ссылки')
                                ->maxLength(255),
                        ])->columns(1)->columnSpan(1)
                    ])->columns(2),
                    SpatieMediaLibraryFileUpload::make('promo_pics')
                        ->collection('promo_pics')
                        ->image()
                        ->reorderable()
                        ->label('')
                        ->imageEditor()
                        ->panelLayout('grid')
                        ->imageEditorMode(2)
                        ->imageResizeMode('cover')
                        ->label('Обложка')
                        ->imageCropAspectRatio('460:280')
                        ->columnSpanFull(),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                ToggleColumn::make('flg_active')
                    ->label('Есть на сайте'),
                TextColumn::make('link_text')
                    ->label('Текст ссылки')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Создана')
                    ->sortable(),
                TextColumn::make('position')
                    ->label('Порядок')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('created_at', 'desc')
                    ->orderBy('position');
            })
            ->defaultSort('position')
            ->reorderable('position')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromos::route('/'),
            'create' => CreatePromo::route('/create'),
            'edit' => EditPromo::route('/{record}/edit'),
        ];
    }
}

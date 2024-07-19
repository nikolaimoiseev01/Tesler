<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoResource\Pages;
use App\Filament\Resources\PromoResource\RelationManagers;
use App\Models\Promo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-trending-up';

    protected static ?string $navigationLabel = 'Промо-акции';

    protected static ?string $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('type')
                            ->label('Тип акции')
                            ->maxLength(255),
                    ]),

                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Textarea::make('desc')
                            ->label('Описание')
                            ->required()
                            ->rows(5)
                            ->columnSpan(1),
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('link')
                                ->label('Куда ведет ссылка')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('link_text')
                                ->label('Текст ссылки')
                                ->maxLength(255),
                        ])->columns(1)->columnSpan(1)
                    ])->columns(2),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('promo_pics')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('flg_active')
                    ->label('Есть на сайте'),
                Tables\Columns\TextColumn::make('link_text')
                    ->label('Текст ссылки')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Создана')
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Порядок')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('created_at', 'desc')
                    ->orderBy('position');
            })
            ->defaultSort('position')
            ->reorderable('position')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
        ];
    }
}

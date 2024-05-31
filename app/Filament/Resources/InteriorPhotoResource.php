<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InteriorPhotoResource\Pages;
use App\Filament\Resources\InteriorPhotoResource\RelationManagers;
use App\Models\InteriorPhoto;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InteriorPhotoResource extends Resource
{
    protected static ?string $model = InteriorPhoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Фото интерьера';

    protected static ?string $navigationGroup = 'Настройки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('interior_photos')
                    ->collection('interior_photos')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->label('')
                    ->imageEditor()
                    ->panelLayout('grid')
                    ->imageEditorMode(2)
                    ->imageResizeMode('cover')
                    ->label('Примеры')
                    ->imageCropAspectRatio('9:16')
                    ->imageResizeTargetWidth('1080')
                    ->imageResizeTargetHeight('1920')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pic')
                    ->label('')
                    ->getStateUsing(function (Model $record) {
                        return 'Нажмите, чтобы посмотреть или изменить фото интерьера';
                    }),
            ])
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
            'index' => Pages\ManageInteriorPhotos::route('/'),
        ];
    }
}

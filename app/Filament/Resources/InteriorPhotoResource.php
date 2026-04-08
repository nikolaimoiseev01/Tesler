<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\InteriorPhotoResource\Pages\ManageInteriorPhotos;
use App\Filament\Resources\InteriorPhotoResource\Pages;
use App\Filament\Resources\InteriorPhotoResource\RelationManagers;
use App\Models\InteriorPhoto;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InteriorPhotoResource extends Resource
{
    protected static ?string $model = InteriorPhoto::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Фото интерьера';

    protected static string | \UnitEnum | null $navigationGroup = 'Настройки';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('interior_photos')
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
                TextColumn::make('pic')
                    ->label('')
                    ->getStateUsing(function (Model $record) {
                        return 'Нажмите, чтобы посмотреть или изменить фото интерьера';
                    }),
            ])
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
            'index' => ManageInteriorPhotos::route('/'),
        ];
    }
}

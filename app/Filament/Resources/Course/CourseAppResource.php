<?php

namespace App\Filament\Resources\Course;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Course\CourseAppResource\Pages\ListCourseApps;
use App\Filament\Resources\Course\CourseAppResource\Pages\CreateCourseApp;
use App\Filament\Resources\Course\CourseAppResource\Pages\EditCourseApp;
use App\Filament\Resources\Course\CourseAppResource\Pages;
use App\Filament\Resources\Course\CourseAppResource\RelationManagers;
use App\Models\ConsultStatus;
use App\Models\Course\CourseApp;
use App\Models\Good\Good_skin_type;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class CourseAppResource extends Resource
{
    protected static ?string $model = CourseApp::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-down-circle';

    protected static ?string $navigationLabel = 'Заявки на курсы';
    protected static string | \UnitEnum | null $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 6;



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('consult_status_id', 1)->count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('user_mobile')
                    ->required()
                    ->maxLength(255),
                TextInput::make('user_comment')
                    ->required()
                    ->maxLength(255),
                TextInput::make('course_id')
                    ->required()
                    ->numeric(),
                TextInput::make('consult_status_id')
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
                    ->label('Комментарий')
                    ->searchable(),
                TextColumn::make('course.title')
                    ->url(fn($record): string => CourseResource::getUrl('edit',['record'=>$record->id]), True)
                    ->sortable(),
                TextColumn::make('consult_status_id')
                    ->searchable(),
                SelectColumn::make('consult_status_id')
                    ->options(ConsultStatus::all()->pluck('title', 'id'))
                    ->label('Статус'),
                TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m H:i')
                    ->sortable(),
            ])
            ->recordUrl('')
            ->filters([
                //
            ])
            ->recordActions([
//                Tables\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => ListCourseApps::route('/'),
            'create' => CreateCourseApp::route('/create'),
            'edit' => EditCourseApp::route('/{record}/edit'),
        ];
    }
}

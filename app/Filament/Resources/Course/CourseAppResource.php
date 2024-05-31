<?php

namespace App\Filament\Resources\Course;

use App\Filament\Resources\Course\CourseAppResource\Pages;
use App\Filament\Resources\Course\CourseAppResource\RelationManagers;
use App\Models\ConsultStatus;
use App\Models\Course\CourseApp;
use App\Models\Good\Good_skin_type;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-circle';

    protected static ?string $navigationLabel = 'Заявки на курсы';
    protected static ?string $navigationGroup = 'Популярное';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('consult_status_id', 1)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_mobile')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_comment')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('course_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('consult_status_id')
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
                    ->label('Комментарий')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->url(fn($record): string => CourseResource::getUrl('edit',['record'=>$record->id]), True)
                    ->sortable(),
                Tables\Columns\TextColumn::make('consult_status_id')
                    ->searchable(),
                SelectColumn::make('consult_status_id')
                    ->options(ConsultStatus::all()->pluck('title', 'id'))
                    ->label('Статус'),
            ])
            ->recordUrl('')
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListCourseApps::route('/'),
            'create' => Pages\CreateCourseApp::route('/create'),
            'edit' => Pages\EditCourseApp::route('/{record}/edit'),
        ];
    }
}

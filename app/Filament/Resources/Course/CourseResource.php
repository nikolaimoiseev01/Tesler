<?php

namespace App\Filament\Resources\Course;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\TextSize;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Course\CourseResource\Pages\ListCourses;
use App\Filament\Resources\Course\CourseResource\Pages\CreateCourse;
use App\Filament\Resources\Course\CourseResource\Pages\EditCourse;
use App\Filament\Resources\Course\CourseResource\Pages;
use App\Filament\Resources\Course\CourseResource\RelationManagers;
use App\Models\Course\Course;
use App\Models\Good\Good_skin_type;
use App\Models\Staff;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use JeroenNoten\LaravelAdminLte\View\Components\Widget\Card;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Курсы';
    protected static string | \UnitEnum | null $navigationGroup = 'Настройки';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Общее')->schema([
                            Grid::make(2)->schema([
                                Grid::make(1)->schema([
                                    TextInput::make('title')
                                        ->required()
                                        ->label('Название')
                                        ->maxLength(255),
                                    Select::make('staff_id')
                                        ->options(Staff::all()->pluck('yc_name', 'id'))
//                                ->relationship(name: 'staff', titleAttribute: 'yc_name')
                                        ->searchable()
                                        ->label('Сотрудник'),
                                    TextInput::make('price')
                                        ->label('Цена')
                                        ->numeric()
                                        ->prefix('$'),
                                    TextInput::make('type')
                                        ->label('Тип')
                                        ->maxLength(255),
                                ])->columnSpan(1),
                                SpatieMediaLibraryFileUpload::make('course_cover')
                                    ->collection('course_cover')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->label('')
                                    ->imageEditor()
                                    ->panelLayout('grid')
                                    ->imageEditorMode(2)
                                    ->imageResizeMode('cover')
                                    ->label('Обложка')
                                    ->imageCropAspectRatio('9:16')
                                    ->imageResizeTargetWidth('1080')
                                    ->imageResizeTargetHeight('1920')
                                    ->columnSpan(['lg' => 1])->columnSpan(1),
                            ])->columns(2),
                            Grid::make(2)->schema([
                                Textarea::make('desc_small')
                                    ->label('Описание маленькое'),
                                Textarea::make('desc')
                                    ->label('Описание'),
                                Textarea::make('proccess')
                                    ->label('Процесс'),
                                Textarea::make('program')
                                    ->label('Программа'),
                                Textarea::make('dates')
                                    ->label('Даты'),
                                Textarea::make('learning')
                                    ->label('Обучение'),
                            ])->columns(2)
                        ]),
                        Tab::make('Примеры')->schema([
                            SpatieMediaLibraryFileUpload::make('course_examples')
                                ->collection('course_examples')
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->label('')
                                ->imageEditor()
                                ->panelLayout('grid')
                                ->imageEditorMode(2)
                                ->imageResizeMode('cover')
                                ->label('')
                                ->imageCropAspectRatio('9:16')
                                ->imageResizeTargetWidth('1080')
                                ->imageResizeTargetHeight('1920')
                                ->columnSpan(['lg' => 1]),
                        ])
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->weight(FontWeight::SemiBold)
                        ->limit(50)
                        ->searchable()
                        ->size(TextSize::Large),
                    TextColumn::make('type')
                        ->label('Тип')
                        ->searchable(),
                    TextColumn::make('price')
                        ->money('RUB'),
                ])

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
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
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}

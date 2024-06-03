<?php

namespace App\Filament\Resources\Course;

use App\Filament\Resources\Course\CourseResource\Pages;
use App\Filament\Resources\Course\CourseResource\RelationManagers;
use App\Models\Course\Course;
use App\Models\Good\Good_skin_type;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Курсы';
    protected static ?string $navigationGroup = 'Настройки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Общее')->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Grid::make(1)->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->label('Название')
                                        ->maxLength(255),
                                    Forms\Components\Select::make('staff_id')
                                        ->options(Staff::all()->pluck('yc_name', 'id'))
//                                ->relationship(name: 'staff', titleAttribute: 'yc_name')
                                        ->searchable()
                                        ->label('Сотрудник'),
                                    Forms\Components\TextInput::make('price')
                                        ->label('Цена')
                                        ->numeric()
                                        ->prefix('$'),
                                    Forms\Components\TextInput::make('type')
                                        ->label('Тип')
                                        ->maxLength(255),
                                ])->columnSpan(1),
                                Forms\Components\SpatieMediaLibraryFileUpload::make('course_cover')
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
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Textarea::make('desc_small')
                                    ->label('Описание маленькое'),
                                Forms\Components\Textarea::make('desc')
                                    ->label('Описание'),
                                Forms\Components\Textarea::make('proccess')
                                    ->label('Процесс'),
                                Forms\Components\Textarea::make('program')
                                    ->label('Программа'),
                                Forms\Components\Textarea::make('dates')
                                    ->label('Даты'),
                                Forms\Components\Textarea::make('learning')
                                    ->label('Обучение'),
                            ])->columns(2)
                        ]),
                        Tabs\Tab::make('Примеры')->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('course_examples')
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
                    Tables\Columns\TextColumn::make('title')
                        ->weight(FontWeight::SemiBold)
                        ->limit(50)
                        ->searchable()
                        ->size(Tables\Columns\TextColumn\TextColumnSize::Large),
                    Tables\Columns\TextColumn::make('type')
                        ->label('Тип')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('price')
                        ->money('RUB'),
                ])

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}

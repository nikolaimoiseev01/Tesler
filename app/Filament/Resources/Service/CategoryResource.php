<?php

namespace App\Filament\Resources\Service;

use App\Filament\Resources\Service\CategoryResource\Pages;
use App\Filament\Resources\Service\CategoryResource\RelationManagers;
use App\Models\Promo;
use App\Models\Service\Category;
use App\Models\Service\Scope;
use App\Models\Staff;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Категории';
    protected static ?string $navigationGroup = 'Модель услуг';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make('xl')->schema([
                    Tabs::make('Tabs')
                        ->tabs([
                            Tabs\Tab::make('Общее')
                                ->schema([
                                    Grid::make()->schema([
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('main_pic')
                                            ->collection('main_pic')
                                            ->image()
                                            ->label('')
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('610:710')
                                            ->columnSpan(['lg' => 1]),
                                        Forms\Components\Grid::make(1)->schema([
                                            Placeholder::make('Сфера')
                                                ->visible(fn($context) => $context === 'edit')
                                                ->content(fn(Category $record): string => $record->scope['name']),
                                            Forms\Components\Select::make('scope_id')
                                                ->relationship(name: 'scope', titleAttribute: 'name')
                                                ->visible(fn($context) => $context === 'create')
                                                ->label('Сфера'),
                                            Forms\Components\TextInput::make('name')
                                                ->required()
                                                ->label('Название')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('block_title')
                                                ->required()
                                                ->label('Заголовок блока')
                                                ->maxLength(255),
                                            Forms\Components\Select::make('promo_id')
                                                ->relationship(name: 'promo', titleAttribute: 'title')
                                                ->options(Promo::all()->pluck('title', 'id'))
                                                ->searchable()
                                                ->label('Поп-ап'),
                                        ])->columnSpan(['lg' => 1]),
                                    ])->columns(2),
                                    Forms\Components\Textarea::make('desc')
                                        ->required()
                                        ->label('Описание категории')
                                        ->maxLength(255),
                                ]),
                            Tabs\Tab::make('Мастера в категории')->schema([
                                Forms\Components\Card::make([
                                    Repeater::make('staff_ids')
                                        ->simple(
                                            Select::make('staff_id')
                                                ->label('')
                                                ->options(Staff::all()->pluck('yc_name', 'id'))
                                                ->searchable()
                                                ->required()
                                        )
                                        ->label('')
                                        ->addAction(
                                            fn(Action $action) => $action->label('Добавить мастера'),
                                        )
                                        ->grid(4)
                                ])
                            ]),
                            Tabs\Tab::make('Примеры в категории')->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('category_examples')
                                    ->collection('category_examples')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->label('')
                                    ->imageEditor()
                                    ->panelLayout('grid')
                                    ->imageEditorMode(2)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('11:16')
                                    ->columnSpan(['lg' => 1]),
                            ])
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('scope.name')
                    ->label('Сфера')
                    ->sortable(),
                TextColumn::make('group_count')->counts('group')->label('Групп в категории'),
                TextColumn::make('service_count')->counts('service')->label('Услуг в категории')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('scope_id')
                    ->label('Сфера')
                    ->relationship('scope', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort(fn($query) => $query->orderBy('scope_id', 'asc')->orderBy('position', 'asc'))
            ->reorderable('position')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        $category = Category::where('id', 1)->first();
//        dd($category->group);
        foreach ($category->group as $group) {
            if ($group['id'] = 4) {
//                dd($group);
            }
        }
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

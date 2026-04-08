<?php

namespace App\Filament\Resources\Service;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use App\Filament\Resources\Service\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\Service\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\Service\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\Service\CategoryResource\Pages;
use App\Filament\Resources\Service\CategoryResource\RelationManagers;
use App\Models\Promo;
use App\Models\Service\Category;
use App\Models\Service\Scope;
use App\Models\Staff;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Категории';
    protected static string | \UnitEnum | null $navigationGroup = 'Модель услуг';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make('xl')->schema([
                    Tabs::make('Tabs')
                        ->tabs([
                            Tab::make('Общее')
                                ->schema([
                                    Grid::make()->schema([
                                        SpatieMediaLibraryFileUpload::make('main_pic')
                                            ->collection('main_pic')
                                            ->image()
                                            ->label('')
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('610:710')
                                            ->columnSpan(['lg' => 1]),
                                        Grid::make(1)->schema([
                                            Placeholder::make('Сфера')
                                                ->visible(fn($context) => $context === 'edit')
                                                ->content(fn(Category $record): string => $record->scope['name']),
                                            Select::make('scope_id')
                                                ->relationship(name: 'scope', titleAttribute: 'name')
                                                ->visible(fn($context) => $context === 'create')
                                                ->label('Сфера'),
                                            TextInput::make('name')
                                                ->required()
                                                ->label('Название')
                                                ->maxLength(255),
                                            TextInput::make('block_title')
                                                ->required()
                                                ->label('Заголовок блока')
                                                ->maxLength(255),
                                            Select::make('promo_id')
                                                ->relationship(name: 'promo', titleAttribute: 'title')
                                                ->options(Promo::all()->pluck('title', 'id'))
                                                ->searchable()
                                                ->label('Поп-ап'),
                                        ])->columnSpan(['lg' => 1]),
                                    ])->columns(2),
                                    Textarea::make('desc')
                                        ->required()
                                        ->label('Описание категории')
                                        ->maxLength(255),
                                ]),
                            Tab::make('Мастера в категории')->schema([
                                Section::make([
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
                            Tab::make('Примеры в категории')->schema([
                                SpatieMediaLibraryFileUpload::make('category_examples')
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
                SelectFilter::make('scope_id')
                    ->label('Сфера')
                    ->relationship('scope', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort(fn($query) => $query->orderBy('scope_id', 'asc')->orderBy('position', 'asc'))
            ->reorderable('position')
            ->toolbarActions([
                BulkActionGroup::make([
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}

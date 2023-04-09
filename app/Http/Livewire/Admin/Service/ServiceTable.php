<?php

namespace App\Http\Livewire\Admin\Service;

use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button,
    Column,
    Exportable,
    Footer,
    Header,
    PowerGrid,
    PowerGridComponent,
    PowerGridEloquent
};

final class ServiceTable extends PowerGridComponent
{
    use ActionButton;


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Service>
     */
    public function datasource(): Builder
    {
        return Service::query()
            ->leftjoin('scopes', 'services.scope_id', '=', 'scopes.id')
            ->leftjoin('categories', 'services.category_id', '=', 'categories.id')
            ->leftjoin('groups', 'services.group_id', '=', 'groups.id')
            ->select('services.*',
                DB::raw('ifnull(scopes.name, "Не выбрано") as scope_name'),
                DB::raw('ifnull(categories.name, "Не выбрано") as category_name'),
                DB::raw('ifnull(groups.name, "Не выбрано") as group_name')
            );
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('yc_id')
            ->addColumn('name')
            ->addColumn('scope_name')
            ->addColumn('category_name')
            ->addColumn('group_name')
            ->addColumn('flg_active')
            ->addColumn('flg_top_master');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('YC_ID', 'yc_id')
                ->searchable()
                ->sortable(),

            Column::make('Название', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Сфера', 'scope_name')
                ->searchable()
                ->sortable(),

            Column::make('Категория', 'category_name')
                ->searchable()
                ->sortable(),

            Column::make('Группа', 'group_name')
                ->searchable()
                ->sortable(),

            Column::make('FLG ACTIVE', 'flg_active')
                ->searchable()
                ->sortable(),

            Column::make('Топ Мастер', 'flg_top_master')
                ->searchable()
                ->sortable(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Service Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::make('edit', 'Подробнее')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
                ->route('service.edit', ['service_id' => 'id']),

//           Button::make('destroy', 'Delete')
//               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
//               ->route('service.destroy', ['service' => 'id'])
//               ->method('delete')
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Service Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($service) => $service->id === 1)
                ->hide(),
        ];
    }
    */
}

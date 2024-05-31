<?php

namespace App\Livewire\Admin\Order;

use App\Models\Good\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\{Button, Column, Footer, Header, PowerGrid, PowerGridColumns, PowerGridComponent};
use PowerComponents\LivewirePowerGrid\Facades\{RuleActions};
use PowerComponents\LivewirePowerGrid\Facades\Filter;

final class OrderTable extends PowerGridComponent
{
    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

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
            Header::make()->showToggleColumns()->showSearchInput(),
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
     * @return Builder<\App\Models\Good\Order>
     */
    public function datasource(): Builder
    {
        return Order::query()->leftjoin('good_deli_statuses', 'good_deli_statuses.id', '=', 'orders.good_deli_status_id')
            ->select('orders.*',
                DB::raw('ifnull(good_deli_statuses.title, "") as deli_status')
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
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('tinkoff_status')
            ->addColumn('goods', fn(Order $model) => count((array)json_decode($model->goods)))
            ->addColumn('price', fn(Order $model) => str($model->price / 100) . ' ₽')
            ->addColumn('need_delivery', fn(Order $model) => ($model->need_delivery == 1) ? 'Нужна доставка' : 'Самостоятельно')
            ->addColumn('deli_status')
            ->addColumn('created_at_formatted', fn (Order $model) => str(Carbon::parse($model->created_at)->format('d/m H:i')))
            ->addColumn('updated_at_formatted', fn (Order $model) => str(Carbon::parse($model->updated_at)->format('d/m H:i')));
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

            Column::make('Статус Tinkoff', 'tinkoff_status')
                ->searchable()
                ->sortable(),
            Column::make('Кол-во товаров', 'goods')
                ->searchable()
                ->sortable(),
            Column::make('Стоимость', 'price')
                ->searchable()
                ->sortable(),

            Column::make('Нужна доставка?', 'need_delivery')
                ->searchable()
                ->sortable(),
            Column::make('Статус доставки', 'deli_status')
                ->searchable()
                ->sortable(),
            Column::make('Создан', 'created_at_formatted')
                ->searchable()
                ->sortable(),
            Column::make('Обновлен', 'updated_at_formatted')
                ->searchable()
                ->sortable(),
            Column::action('Action'),
        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('name'),
//            Filter::datepicker('created_at_formatted', 'created_at'),
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
     * PowerGrid Order Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions($row): array
    {
        return [
            Button::make('edit', 'Подробнее')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
                ->route('order.edit', ['order_id' => $row->id]),

//           Button::make('destroy', 'Delete')
//               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
//               ->route('order.destroy', ['order' => 'id'])
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
     * PowerGrid Order Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($order) => $order->id === 1)
                ->hide(),
        ];
    }
    */
}

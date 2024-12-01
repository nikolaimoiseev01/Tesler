<?php

namespace App\Filament\Widgets;

use App\Models\Good\Good;
use App\Models\Service\Service;
use App\Models\Staff;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GoodsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Услуг на сайте', function() {
                $total_services = Service::count();
                $active_services = Service::where('flg_active', 1)->count();
                return "$total_services (акт: $active_services)";
            } ),
            Stat::make('Товаров на сайте', function() {
                $total_goods = Good::count();
                $active_goods = Good::where('flg_active', 1)->count();
                return "$total_goods (акт: $active_goods)";
            } ),
            Stat::make('Мастеров на сайте', function() {
                $total_staff = Staff::count();
                $active_staff = Staff::where('flg_active', 1)->count();
                return "$total_staff (акт: $active_staff)";
            } ),
        ];
    }
}

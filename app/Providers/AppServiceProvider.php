<?php

namespace App\Providers;

use App\Models\Service\Scope;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }



        // Регистрируем значение в контейнере службы
        $this->app->singleton('chosen_shop', function ($app) {
            $minutes = 60 * 24 * 7; // 7 дней
            $chosen_yc_shop = json_decode(Cookie::get('chosen_shop'));
            // Если нет еще, то ставим первый
            if (!$chosen_yc_shop) {
                $chosen_yc_shop = config('cons.yc_shops')[0];
                Cookie::queue('chosen_shop', json_encode($chosen_yc_shop), $minutes);
            } else {
                $chosen_yc_shop = get_object_vars($chosen_yc_shop);
            }
            return $chosen_yc_shop;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        view()->composer('*', function ($view) {
            $scopes_menu_mobile = Scope::where('flg_active', 1)->orderBy('name')->get();
            $view->with([
                'scopes_menu_mobile' => $scopes_menu_mobile
            ]);
        });

    }
}

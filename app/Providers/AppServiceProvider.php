<?php

namespace App\Providers;

use App\Models\Service\Scope;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
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

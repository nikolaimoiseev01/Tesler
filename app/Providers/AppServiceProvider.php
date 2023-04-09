<?php

namespace App\Providers;

use App\Models\Scope;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $scopes_menu_mobile = Scope::orderBy('name')->get();
            $view->with([
                'scopes_menu_mobile' => $scopes_menu_mobile,
            ]);
        });

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Product;
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
        View::composer('layouts.navigation', function ($view) {
            $view->with('globalCategories', Product::select('category')->distinct()->pluck('category'));
        });
    }
}

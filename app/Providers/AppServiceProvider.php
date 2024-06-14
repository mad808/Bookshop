<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Booklang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
//use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Paginator::useBootstrapFive();

        View::composer('app.nav', function ($view) {
            $brands = Brand::orderBy('name')
                ->get();
            $booklangs = Booklang::orderBy('name')
                ->get();

            $view->with([
                'brands' => $brands,
                'booklangs' => $booklangs,
            ]);
        });
    }
}

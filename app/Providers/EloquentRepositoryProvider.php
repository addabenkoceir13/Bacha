<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\EloquentCategory;
use App\Repositories\Sales\EloquentSales;
use App\Repositories\Sales\SalesRepository;
use Illuminate\Support\ServiceProvider;

class EloquentRepositoryProvider extends ServiceProvider
{
/**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(CategoryRepository::class, EloquentCategory::class);
      $this->app->bind(SalesRepository::class, EloquentSales::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

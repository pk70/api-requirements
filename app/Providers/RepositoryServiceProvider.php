<?php

namespace App\Providers;

use App\Http\Controllers\Api\Products\ProductsController;
use App\Interfaces\ProductsRepositoryInterface;
use App\Repository\ProductsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->when(ProductsController::class)
        ->needs(ProductsRepositoryInterface::class,ProductsRepository::class)
        ->give(function () {
          return new ProductsRepository;
      });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

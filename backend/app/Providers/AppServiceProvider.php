<?php

namespace App\Providers;

use App\Repositories\travel_orders\TravelOrdersRepository;
use App\Repositories\travel_orders\TravelOrdersRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TravelOrdersRepositoryInterface::class, TravelOrdersRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

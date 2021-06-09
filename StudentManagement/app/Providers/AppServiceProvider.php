<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Repository_Interface\ResultRepositoryInterface::class,
            \App\Repositories\ResultRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Repository_Interface\StudentRepositoryInterface::class,
            \App\Repositories\StudentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

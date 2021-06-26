<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\SendMailDismiss;
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
        $this->app->singleton(
            \App\Repositories\Repository_Interface\SubjectRepositoryInterface::class,
            \App\Repositories\SubjectRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Repository_Interface\DepartmentRepositoryInterface::class,
            \App\Repositories\DepartmentRepository::class
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

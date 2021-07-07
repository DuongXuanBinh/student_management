<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
            \App\Repositories\RepositoryInterface\ResultRepositoryInterface::class,
            \App\Repositories\ResultRepository::class
        );
        $this->app->singleton(
            \App\Repositories\RepositoryInterface\StudentRepositoryInterface::class,
            \App\Repositories\StudentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\RepositoryInterface\SubjectRepositoryInterface::class,
            \App\Repositories\SubjectRepository::class
        );
        $this->app->singleton(
            \App\Repositories\RepositoryInterface\DepartmentRepositoryInterface::class,
            \App\Repositories\DepartmentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\RepositoryInterface\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapThree();
    }
}

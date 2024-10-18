<?php

namespace App\Providers;

use App\Interfaces\AbsenInterface;
use App\Interfaces\PegawaiInterface;
use App\Repositories\AbsenRepositories;
use App\Repositories\PegawaiRepositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AbsenInterface::class, AbsenRepositories::class);
        $this->app->bind(PegawaiInterface::class, PegawaiRepositories::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Interfaces\PegawaiInterface;
use App\Repositories\PegawaiRepositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
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

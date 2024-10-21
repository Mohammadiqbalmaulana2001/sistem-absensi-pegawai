<?php

namespace App\Providers;

use App\Interfaces\AbsenInterface;
use App\Interfaces\KameraInterface;
use App\Interfaces\LokasiInterface;
use App\Interfaces\PegawaiInterface;
use App\Repositories\AbsenRepositories;
use App\Repositories\KameraRepositories;
use App\Repositories\LokasiRepositories;
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
        $this->app->bind(LokasiInterface::class, LokasiRepositories::class);
        $this->app->bind(KameraInterface::class, KameraRepositories::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

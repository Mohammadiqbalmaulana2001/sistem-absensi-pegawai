<?php

namespace App\Providers;

use App\Interfaces\AbsenInterface;
use App\Interfaces\KameraInterface;
use App\Interfaces\KebijakanAbsensiInterface;
use App\Interfaces\LogAktivitasInterface;
use App\Interfaces\LokasiInterface;
use App\Interfaces\PegawaiInterface;
use App\Repositories\AbsenRepositories;
use App\Repositories\KameraRepositories;
use App\Repositories\KebijakanAbsensiRepositories;
use App\Repositories\LogAktivitasRepositories;
use App\Repositories\LokasiRepositories;
use App\Repositories\PegawaiRepositories;
use Illuminate\Container\Attributes\Log;
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
        $this->app->bind(KebijakanAbsensiInterface::class, KebijakanAbsensiRepositories::class);
        $this->app->bind(LogAktivitasInterface::class, LogAktivitasRepositories::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

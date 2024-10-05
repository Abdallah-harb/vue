<?php

namespace App\Providers;

use App\Interface\Auth\AuthInterface;
use App\Interface\Blog\BlogInterface;
use App\Repository\Auth\AuthRepository;
use App\Repository\BlogRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(BlogInterface::class,BlogRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

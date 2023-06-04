<?php

namespace App\Providers;

use App\Services\TrackedLocationService;
use Illuminate\Support\ServiceProvider;

class TrackedLocationServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует любые сервисы приложения.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TrackedLocationService::class, function ($app) {
            return new TrackedLocationService();
        });
    }

    /**
     * Выполняет действия после регистрации сервисов.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

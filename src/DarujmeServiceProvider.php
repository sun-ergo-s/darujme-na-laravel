<?php

namespace SunErgoS\DarujmeNaLaravel;

use Illuminate\Support\ServiceProvider;
use SunErgoS\DarujmeNaLaravel\DarujmeNaLaravel;

class DarujmeServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/darujme.php' => $this->app->configPath('darujme.php'),
        ]);
    }

    public function register(): void
    {

        $this->mergeConfigFrom(
            __DIR__.'/../config/darujme.php', 'darujme'
        );

        $this->app->singleton('darujme', function() {
            return new DarujmeNaLaravel();
        });

    }
    
}
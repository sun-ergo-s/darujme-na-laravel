<?php

namespace SunErgoS\DarujmeNaLaravel;

use Illuminate\Support\ServiceProvider;
use SunErgoS\DarujmeNaLaravel\Darujme;

class DarujmeServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/darujme.php' => $this->app->configPath('darujme.php'),
            ], 'darujme-config');
        }
    }

    public function register(): void
    {

        $this->mergeConfigFrom(
            __DIR__.'/../config/darujme.php', 'darujme'
        );

        $this->app->singleton('darujme', function() {
            return new Darujme();
        });

    }
    
}
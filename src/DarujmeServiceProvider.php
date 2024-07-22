<?php

namespace SunErgoS\DarujmeNaLaravel;

use Illuminate\Support\ServiceProvider;
use SunErgoS\DarujmeNaLaravel\DarujmeNaLaravel;

class DarujmeServiceProvider extends ServiceProvider {

    public function register(): void
    {

        $this->mergeConfigFrom('./../config/darujme.php', 'darujme');

        $this->app->singleton('darujme', function() {
            return new DarujmeNaLaravel();
        });

    }
    
}
<?php

namespace SunErgoS\DarujmeNaLaravel;

use Illuminate\Support\ServiceProvider;
use SunErgoS\DarujmeNaLaravel\Darujme;

class DarujmeServiceProvider extends ServiceProvider {

    public function register(){

        $this->app->bind('darujme',function() {
            return new Darujme;
        });

    }
    
}
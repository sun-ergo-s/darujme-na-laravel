<?php

namespace SunErgoS\DarujmeNaLaravel;

class BaseDarujme {

    use Concerns\HttpClient;

    /**
     * Pripraví HTTP klienta
     * 
     * @return void
     */
    public function __construct()
    {        
        self::prepareHttpRequest();
    }

}
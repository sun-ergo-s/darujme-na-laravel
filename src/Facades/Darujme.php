<?php

namespace SunErgoS\DarujmeNaLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Darujme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'darujme';
    }
}
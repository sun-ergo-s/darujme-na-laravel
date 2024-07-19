<?php

namespace SunErgoS\DarujmeNaLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use SunErgoS\DarujmeNaLaravel\DarujmeNaLaravel;

class Darujme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DarujmeNaLaravel::class;
    }
}
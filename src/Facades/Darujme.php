<?php

namespace SunErgoS\DarujmeNaLaravel;

use Illuminate\Support\Facades\Facade;

class Debugbar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SunErgoS\DarujmeNaLaravel\Darujme::class;
    }
}
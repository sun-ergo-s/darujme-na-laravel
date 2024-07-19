<?php

namespace SunErgoS\DarujmeNaLaravel;

use Illuminate\Support\Facades\Facade;

class Darujme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SunErgoS\DarujmeNaLaravel\Darujme::class;
    }
}
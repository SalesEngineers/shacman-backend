<?php

namespace App\SypexGeo;

use Illuminate\Support\Facades\Facade;

class SypexGeoFacade extends Facade
{
    protected static function getFacadeAccessor() { return SypexGeo::class; }
}
<?php

namespace App\SypexGeo;

use Illuminate\Support\ServiceProvider;

class SypexGeoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SypexGeo::class, function() {
            $database   = config('sypexgeo.file');
            $db         = app_path('SypexGeo' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . $database);
            $sxgeo      = new SxGeo($db);

            return new SypexGeo(
                $sxgeo,
                ['default' => config('sypexgeo.default', [])]
            );
        });
    }
}

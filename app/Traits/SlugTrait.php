<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugTrait
{
    /**
     * Установить slug
     *
     * @param $model
     */
    public static function setSlug($model)
    {
        if ($model->url) {
            $model->url = Str::slug($model->url, '-');
        }
    }
}

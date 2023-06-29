<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);
Encore\Admin\Admin::js('//api-maps.yandex.ru/2.1/?apikey=2b2f535a-5940-453e-b7a3-c723a9c1d0fe&lang=ru_RU');
Encore\Admin\Admin::js(asset('js/map.js'));
\Encore\Admin\Form::extend('imageService', \App\Services\ImageService::class);
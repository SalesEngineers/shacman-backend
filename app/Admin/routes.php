<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    // Акции
    $router->resource('promotions', PromotionController::class);
    // Категории
    $router->resource('categories', CategoryController::class);
    // Лейблы
    $router->resource('labels', LabelController::class);
    // Характеристики
    $router->resource('characteristics', CharacteristicController::class);
    // Спецтехника
    $router->resource('products-special-machinery', ProductSpecialMachineryController::class);
    // Навесное оборудование
    $router->resource('products-attached-equipment', ProductAttachedEquipmentController::class);
    // Дерево категорий (сортировка)
    $router->resource('category-trees', CategoryTreeController::class);
    // Настройки
    $router->get('settings', 'SettingsController@index')->name('settings');
    // Контакты
    $router->resource('contacts', ContactController::class);
    // Статьи
    $router->resource('articles', ArticleController::class);
    // Заявки
    $router->resource('form-orders', FormOrderController::class);
    // Галерея
    $router->resource('galleries', GalleryController::class);
    // Группы характеристик
    $router->resource('groups', GroupController::class);
});

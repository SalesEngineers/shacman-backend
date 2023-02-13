<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Категории
Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class)->only(['index', 'show']);
// Список товаров
Route::get('categories/{category}/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
// Товар
Route::get('products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'show']);
// Характеристики
Route::get('characteristics', \App\Http\Controllers\Api\CharacteristicController::class)->name('characteristics.index');
// Настройки
Route::get('settings', \App\Http\Controllers\Api\SettingsController::class)->name('settings');
// Контакты
Route::get('contacts', [\App\Http\Controllers\Api\ContactController::class, 'index'])->name('contacts');
Route::get('contacts/dynamic', [\App\Http\Controllers\Api\ContactController::class, 'dynamic'])->name('contacts-dynamic');
Route::get('contacts/location', [\App\Http\Controllers\Api\ContactController::class, 'location'])->name('contacts-location');
// Статьи
Route::apiResource('articles', \App\Http\Controllers\Api\ArticleController::class)->only(['index', 'show']);
// Заявки
Route::post('form-order', \App\Http\Controllers\Api\FormOrderController::class)->name('form-order');

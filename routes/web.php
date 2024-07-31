<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
route::controller(ProductController::class)
 ->prefix('products')
 ->name('products.')
 ->group(static function()
 {
    route::get('','list')->name('list');
    route::get('/{products}','show')->name('view');
 });
 route::controller(ShopController::class)
 ->prefix('shops')
 ->name('shops.')
 ->group(static function()
 {
    route::get('','list')->name('list');
    route::get('/{shops}','show')->name('view');
 });
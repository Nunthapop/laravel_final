<?php

use App\Http\Controllers\ProductController;
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
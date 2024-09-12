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
   ->group(function () {
      route::get('', 'list')->name('list');
      route::get('/create', 'showCreateForm')->name('create-form');
      route::post('/create', 'create')->name('create');
      Route::prefix('/{product}')->group(function () {
         Route::get('', 'show')->name('view');
         Route::get('/shop', 'showShops',)->name('view-shops');
         Route::get('/update', 'showUpdateForm')->name('update-form');
         Route::post('/update', 'update')->name('update');
         Route::get('/delete', 'delete')->name('delete');
      });
   });
route::controller(ShopController::class)
   ->prefix('shops')
   ->name('shops.')
   ->group( function () {
      route::get('', 'list')->name('list');
      route::get('/create', 'showCreateForm')->name('create-form');
      route::post('/create', 'create')->name('create');
      Route::prefix('/{shop}')->group(function () {
         Route::get('', 'show')->name('view');
         Route::get('/update', 'showUpdateForm')->name('update-form');
         Route::post('/update', 'update')->name('update');
         Route::get('/delete', 'delete')->name('delete');
      });
   });

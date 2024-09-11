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
      Route::get('/{products}', 'show')->name('view');
      route::get('/create', 'showCreateForm')->name('create-form');
      route::post('/create', 'create')->name('create');
      
      // Route::prefix('/{product}')->group(function () {
       
      //    // Route::get('/update', 'showUpdateForm')->name('update-form');
      //    // Route::post('/update', 'update')->name('update');
      // });
   });
route::controller(ShopController::class)
   ->prefix('shops')
   ->name('shops.')
   ->group(static function () {
      route::get('', 'list')->name('list');
      route::get('/{shops}', 'show')->name('view');
   });

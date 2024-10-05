<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CateController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('welcome');
});
Route::middleware(['auth'])->group(function () {
   Route::prefix('products')
      ->name('products.')
      ->group(function () {
         Route::get('', 'list')->name('list');
         Route::get('/create', 'showCreateForm')->name('create-form');
         Route::post('/create', 'create')->name('create');
         Route::prefix('/{product}')->group(function () {
            Route::get('', 'show')->name('view');
            Route::prefix('/shops')->group(function () {
               Route::get('', 'showShops')->name('view-shops');
               Route::get('/add', 'showAddShopsForm')->name('add-shops-form');
               Route::post('/add', 'addShop')->name('add-shop');
            });

            Route::get('/{shop}/remove', 'removeShop')->name('remove-shop');
            Route::get('/update', 'showUpdateForm')->name('update-form');
            Route::post('/update', 'update')->name('update');
            Route::get('/delete', 'delete')->name('delete');
         });

         // Route definition for ShopController
         Route::controller(ShopController::class)->group(function () {
            Route::prefix('shops')
               ->name('shops.')
               ->group(function () {
                  route::get('', 'list')->name('list');
                  route::get('/create', 'showCreateForm')->name('create-form');
                  route::post('/create', 'create')->name('create');
                  Route::prefix('/{shop}')->group(function () {
                     Route::get('', 'show')->name('view');
                     Route::prefix('/products')->group(function () {
                        Route::get('', 'showProducts')->name('view-products');
                        Route::get('/add', 'showAddProductsForm')->name('add-products-form');
                        Route::post('/add', 'addProduct')->name('add-product');
                     });
                     Route::get('/{product}/remove', 'removeProduct')->name('remove-product');
                     Route::get('/shop', 'showProducts',)->name('view-products');
                     Route::get('/update', 'showUpdateForm')->name('update-form');
                     Route::post('/update', 'update')->name('update');
                     Route::get('/delete', 'delete')->name('delete');
                  });
               });
         });

         // Route definition for CategoryController
         Route::controller(CateController::class)->group(function () {
            Route::prefix('category')
               ->name('category.')
               ->group(function () {
                  route::get('', 'list')->name('list');
                  route::get('/create', 'showCreateForm')->name('create-form');
                  route::post('/create', 'create')->name('create');
                  Route::prefix('/{cateCode}')->group(function () {
                     Route::get('', 'show')->name('view');
                     Route::prefix('/products')->group(function () {
                        Route::get('', 'showProducts')->name('view-products');
                        Route::get('/add', 'showAddProductsForm')->name('add-products-form');
                        Route::post('/add', 'addProduct')->name('add-product');
                     });
                     Route::get('/shop', 'showProducts',)->name('view-products');
                     Route::get('/update', 'showUpdateForm')->name('update-form');
                     Route::post('/update', 'update')->name('update');
                     Route::get('/delete', 'delete')->name('delete');
                  });
               });
         });
      });
});

Route::controller(LoginController::class)
   ->prefix('auth')
   ->name('auth.')
   ->group(function () {
      // name this route to login by default setting.
      Route::get('/login', 'showLoginForm')->name('login');
      Route::post('/login', 'authenticate')->name('authenticate');
      Route::get('/logout', 'logout')->name('logout');
   });
// route::controller(ProductController::class)
//    ->prefix('products')
//    ->name('products.')
//    ->group(function () {
//       route::get('', 'list')->name('list');
//       route::get('/create', 'showCreateForm')->name('create-form');
//       route::post('/create', 'create')->name('create');
//       Route::prefix('/{product}')->group(function () {
//          Route::get('', 'show')->name('view');
//          Route::prefix('/shops')->group(function () {
//             Route::get('', 'showShops')->name('view-shops');
//             Route::get('/add', 'showAddShopsForm')->name('add-shops-form');
//             Route::post('/add', 'addShop')->name('add-shop');
//          });
//          Route::get('/{shop}/remove', 'removeShop')->name('remove-shop');
//          Route::get('/update', 'showUpdateForm')->name('update-form');
//          Route::post('/update', 'update')->name('update');
//          Route::get('/delete', 'delete')->name('delete');
//       });
//    });
// route::controller(ShopController::class)
// Route::prefix('shops')
//    ->name('shops.')
//    ->group(function () {
//       route::get('', 'list')->name('list');
//       route::get('/create', 'showCreateForm')->name('create-form');
//       route::post('/create', 'create')->name('create');
//       Route::prefix('/{shop}')->group(function () {
//          Route::get('', 'show')->name('view');
//          Route::prefix('/products')->group(function () {
//             Route::get('', 'showProducts')->name('view-products');
//             Route::get('/add', 'showAddProductsForm')->name('add-products-form');
//             Route::post('/add', 'addProduct')->name('add-product');
//          });
//          Route::get('/{product}/remove', 'removeProduct')->name('remove-product');
//          Route::get('/shop', 'showProducts',)->name('view-products');
//          Route::get('/update', 'showUpdateForm')->name('update-form');
//          Route::post('/update', 'update')->name('update');
//          Route::get('/delete', 'delete')->name('delete');
//       });
//    });


// route::controller(CateController::class)
//    ->prefix('category')
//    ->name('category.')
//    ->group(function () {
//       route::get('', 'list')->name('list');
//       route::get('/create', 'showCreateForm')->name('create-form');
//       route::post('/create', 'create')->name('create');
//       Route::prefix('/{cateCode}')->group(function () {
//          Route::get('', 'show')->name('view');
//          Route::prefix('/products')->group(function () {
//             Route::get('', 'showProducts')->name('view-products');
//             Route::get('/add', 'showAddProductsForm')->name('add-products-form');
//             Route::post('/add', 'addProduct')->name('add-product');
//          });
//          Route::get('/shop', 'showProducts',)->name('view-products');
//          Route::get('/update', 'showUpdateForm')->name('update-form');
//          Route::post('/update', 'update')->name('update');
//          Route::get('/delete', 'delete')->name('delete');
//       });
//    });

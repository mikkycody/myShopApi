<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
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

Route::group(['prefix' => 'v1', 'middleware' => 'api'], function () {

    Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function () {
        Route::post('register', 'signup')->name('signup');
        Route::post('login', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller(ProductController::class)->name('admin.product.')->prefix('admin/product')->middleware('isAdmin')->group(function () {
        Route::post('/', 'store')->name('store');
    });

    Route::controller(ProductController::class)->name('sales.products.')->prefix('sales/products')->middleware('isSalesRep')->group(function () {
        Route::get('/', 'removedProducts')->name('removed');
    });

    Route::controller(ProductController::class)->name('product.')->prefix('products')->group(function () {
        Route::get('/', 'index')->name('all');
        Route::get('{id}', 'show')->name('show');
        Route::post('remove', 'remove')->name('remove');
    });
    Route::controller(OrderController::class)->name('order.')->prefix('orders')->middleware('auth:api')->group(function () {
        Route::post('/', 'store')->name('store');
        Route::post('checkout', 'checkout')->name('checkout');
    });
});

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
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

Route::group(['prefix' => 'v1', 'middleware' => 'api'], function () {

    Route::name('auth.')->prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'signup'])->name('signup');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::name('admin.product.')->prefix('admin/product')->middleware('isAdmin')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('store');
    });

    Route::name('sales.products.')->prefix('sales/products')->middleware('isSalesRep')->group(function () {
        Route::get('/', [ProductController::class, 'removedProducts'])->name('removed');
    });

    Route::name('product.')->prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('all');
        Route::get('{id}', [ProductController::class, 'show'])->name('show');
    });
    Route::name('cart.')->prefix('carts')->middleware('auth:api')->group(function () {
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::post('add', [CartController::class, 'addToCart'])->name('add');
        Route::post('remove', [CartController::class, 'removeFromCart'])->name('remove');
        Route::post('checkout', [CartController::class, 'checkout'])->name('checkout');
    });

});

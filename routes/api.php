<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->name('auth.')->group(static function () {

    Route::post('login',
        [AuthController::class, 'login']
    )->name('login');

});

Route::middleware('auth:sanctum')->group(static function () {

    Route::get('user', static function (Request $request) {
        return $request->user();
    })->name('user');

    Route::prefix('products')->name('products.')->group(static function () {

        Route::prefix('product')->name('product.')->group(static function () {

            Route::put('{product}',
                [ProductController::class, 'update']
            )->name('update');

        });

    });

});

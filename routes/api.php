<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
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

/**
 * Guest
 */
Route::post('/signup', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);

/**
 * Client
 */
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/cart/{product}', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'show']);
    Route::delete('/cart/{cart}', [CartController::class, 'destroy']);

    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/order', [OrderController::class, 'show']);
});

/**
 * Admin
 */
Route::middleware(['auth:api', 'admin'])->apiResource('product', ProductController::class)->only([
    'store', // POST product
    'update', // PATCH product/{product}
    'destroy', // DELETE product/{product}
]);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FeedsController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\OrderProcessController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//feeds
Route::post('/login', [AuthController::class, 'login']);
Route::get('/setting', [AuthController::class, 'setting']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    //auth
    Route::put('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //shipping city
    Route::get('/shipping-cities', [AuthController::class, 'getShippingCities']);

    //feeds
    Route::get('/feeds', [FeedsController::class, 'getProducts']);
    Route::get('/categories', [FeedsController::class, 'getCategories']);

    //wishlists
    Route::resource('/wishlists', WishlistController::class);

    //order
    Route::get('/orders', [OrderProcessController::class, 'index']);
    Route::post('/orders', [OrderProcessController::class, 'store']);
    Route::get('/orders/detail/{order}', [OrderProcessController::class, 'show']);
    Route::get('/orders/order-product-detail/{order}', [OrderProcessController::class, 'showProductDetail']);
    Route::patch('/orders/payment/{order}', [OrderProcessController::class, 'paid']);
    Route::get('/orders/payment-methods', [OrderProcessController::class, 'paymentMethods']);
});

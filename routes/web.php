<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StickerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeHomeController;
use App\Http\Controllers\BadgeSizeController;
use App\Http\Controllers\PosterSizeController;
use App\Http\Controllers\ProductHomeController;
use App\Http\Controllers\QualityHomeController;
use App\Http\Controllers\StickerSizeController;
use App\Http\Controllers\BadgeQualityController;
use App\Http\Controllers\ShippingCityController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PosterQualityController;
use App\Http\Controllers\StickerQualityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //users
    Route::resource('/users', UserController::class)->only([
        'index', 'update', 'destroy', 'edit'
    ]);
    Route::post('/users/status/{user}', [UserController::class, 'setStatus'])->name('users.status');

    //categories
    Route::resource('/categories', CategoryController::class);
    Route::post('/categories/status/{category}', [CategoryController::class, 'setStatus'])->name('categories.status');

    //products
    Route::get('/product-home', [ProductHomeController::class, 'index'])->name('product-home');

    Route::resource('/products', ProductController::class);
    Route::post('/products/status/{product}', [ProductController::class, 'setStatus'])->name('products.status');

    //setting
    Route::resource('/settings', SettingController::class)->only([
        'index', 'update'
    ]);

    //sizes
    Route::get('/size-home', [SizeHomeController::class, 'index'])->name('size-home');

    Route::resource('/sizes', SizeController::class);
    Route::post('/sizes/status/{size}', [SizeController::class, 'setStatus'])->name('sizes.status');
    Route::post('/sizes/default/{size}', [SizeController::class, 'setDefault'])->name('sizes.default');

    //qualities
    Route::get('/quality-home', [QualityHomeController::class, 'index'])->name('quality-home');

    Route::resource('/qualities', QualityController::class);
    Route::post('/qualities/status/{quality}', [QualityController::class, 'setStatus'])->name('qualities.status');
    Route::post('/qualities/default/{quality}', [QualityController::class, 'setDefault'])->name('qualities.default');

    //order
    Route::resource('/orders', OrderController::class)->only([
        'index', 'update', 'edit', 'destroy'
    ]);

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //city
    Route::resource('/shipping-cities', ShippingCityController::class);
    Route::post('/shipping-cities/status/{shipping_city}', [ShippingCityController::class, 'setStatus'])->name('shipping-cities.status');

    //payment methods
    Route::resource('/payment-methods', PaymentMethodController::class);
    Route::post('/payment-methods/status/{payment_method}', [PaymentMethodController::class, 'setStatus'])->name('payment-methods.status');
});

require __DIR__.'/auth.php';

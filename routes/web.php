<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminImportController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\AuthController;

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/categories', [StorefrontController::class, 'categories'])->name('categories.index');
Route::get('/category/{slug}', [StorefrontController::class, 'category'])->name('categories.show');
Route::get('/products', [StorefrontController::class, 'products'])->name('products.index');
Route::get('/product/{slug}', [StorefrontController::class, 'product'])->name('products.show');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/stripe', [CheckoutController::class, 'stripeCheckout'])->name('checkout.stripe');
Route::post('/checkout/cod', [CheckoutController::class, 'codCheckout'])->name('checkout.cod');
Route::get('/order/confirm/{order}', [CheckoutController::class, 'confirm'])->name('order.confirm');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
});

Route::get('/install', [InstallerController::class, 'run'])->name('install.run');

Route::middleware('throttle:5,1')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', AdminProductController::class)->names('admin.products');
    Route::resource('categories', AdminCategoryController::class)->names('admin.categories');
    Route::resource('coupons', AdminCouponController::class)->names('admin.coupons');
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::post('products/import', [AdminImportController::class, 'importCsv'])->name('admin.products.import');
});

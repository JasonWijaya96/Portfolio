<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Seller\SellerCommentController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use Illuminate\Http\Request;
use App\Models\Product;


Route::redirect('/', '/home');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');


Route::get('/search', [ProductController::class, 'search'])->name('products.search');


Route::get('/on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');
Route::get('/new-arrivals', [ProductController::class, 'newArrivals'])->name('products.new-arrivals');
Route::get('/top-selling', [ProductController::class, 'topSelling'])->name('products.top-selling');

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('brands.show');


Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/products/{id}/comments', [ProductController::class, 'loadComments']);

Route::get('/checkout', [BillingController::class, 'index'])->name('checkout.index');

// Proses penyimpanan pesanan
Route::post('/checkout', [BillingController::class, 'store'])->name('checkout.store');

// Halaman detail pesanan setelah checkout
Route::get('/orders/{id}', [BillingController::class, 'show'])->name('orders.show');

Route::get('/orders', [BillingController::class, 'orderHistory'])->name('orders.index'); // METHOD BA

Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('coupon.apply');

// routes/web.php
Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])->name('products.comments.store');
Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store')->middleware('auth');
// web.php
Route::get('/products/{id}/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::middleware('auth')->group(function () {
    // halaman keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // add to cart
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

    // hapus item
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // update qty (increase | decrease)
    Route::patch('/cart/items/{cartItem}/{action}', [CartController::class, 'updateQty'])->name('cart.update');
});
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// ✅ Optional redirect untuk menjaga compatibility
Route::redirect('/category', '/categories');

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Seller
Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.dashboard.index');

Route::get('/seller/dashboard-load-more', [SellerDashboardController::class, 'loadMore'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.dashboard.load-more');

Route::get('/seller/dashboard/chart-data', [SellerDashboardController::class, 'getChartData'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.dashboard.chart-data');

Route::get('/seller/products/create', [SellerProductController::class, 'create'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.products.create');

Route::post('/seller/products', [SellerProductController::class, 'store'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.products.store');

Route::get('/seller/products/released', [SellerProductController::class, 'katalogs'])
    ->middleware(['auth', 'role:seller'])
    ->name('katalogs');

Route::get('/seller/product/comment', [SellerCommentController::class, 'index'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.comments.index');

Route::post('/seller/products/{product}/comments', [SellerCommentController::class, 'reply'])
    ->middleware(['auth', 'role:seller'])
    ->name('seller.comments.reply');

// Route::middleware(['auth', 'is_seller'])->prefix('seller')->name('seller.')->group(function () {
//     Route::get('/comment', [SellerCommentController::class, 'index'])->name('comments.index');
//     Route::post('/comment/{comment}/reply', [SellerCommentController::class, 'reply'])->name('comments.reply');
// });

// Route::post('/seller/comments', [SellerCommentController::class, 'store'])->name('seller.comments.store');
// Route::post('/seller/comments/{comment}/like', [SellerCommentController::class, 'like'])->name('seller.comments.like');

// Route::get('/seller/products/{product}/comments', [SellerCommentController::class, 'getProductComments'])->name('seller.comments.product');

Route::delete('/products/{id}', [SellerProductController::class, 'destroy']);

Route::put('/products/{id}', [SellerProductController::class, 'update'])->name('products.update');

require __DIR__ . '/auth.php';


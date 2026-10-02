<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;

Route::get('/', [PromotionController::class, 'index'])->name('home');
Route::resource('promotions', PromotionController::class)->except(['index']);
Route::resource('showroom', ShowroomController::class);
Route::view('/about', 'about')->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

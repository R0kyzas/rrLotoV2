<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserTokenMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/')->middleware(CheckUserTokenMiddleware::class)->group(function(){
    Route::get('/', [TicketController::class, 'create'])->name('home');
    Route::post('/store', [TicketController::class, 'store'])->name('store.ticket');
    Route::post('/apply-discount', [TicketController::class, 'applyDiscount'])->name('apply.discount');
    Route::match(['get', 'post'], '/notify/{orderId}', [PaymentController::class, 'notifyPayment'])->name('payment.notify');
});

Route::middleware(CheckUserTokenMiddleware::class)->get('/profile', [UserController::class, 'view'])->name('profile');

Route::prefix('/profile')->middleware(CheckUserTokenMiddleware::class)->group(function(){
    Route::get('/', [UserController::class, 'view'])->name('profile');
    Route::match(['get', 'post'], '/payment/completed/{orderId}', [PaymentController::class, 'processPayment']);
    // Route::match(['get', 'post'], '/payment-return/{orderId}/', [PaymentController::class, 'processPayment'])->name('profile.payment');
});

Route::match(['get', 'post'], '/paysera/notification', [PaymentController::class, 'handleNotification'])->name('profile.payment');
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WinnerController;
use App\Http\Middleware\CheckUserTokenMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
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

Route::group(['middleware' => 'guest'], function (){
    Route::prefix('/')->middleware(CheckUserTokenMiddleware::class)->group(function(){
        Route::get('/', [TicketController::class, 'create'])->name('home');
        Route::post('/store', [TicketController::class, 'store'])->name('store.ticket');
        Route::post('/apply-discount', [TicketController::class, 'applyDiscount'])->name('apply.discount');
        Route::match(['get', 'post'], '/paysera/notification', [PaymentController::class, 'handleNotification'])->name('profile.payment');
        Route::get('/paysera/pay', [PaymentController::class, 'view'])->name('initiatePayment');
    });

    Route::prefix('/profile')->middleware(CheckUserTokenMiddleware::class)->group(function(){
        Route::get('/', [ProfileController::class, 'view'])->name('profile.view');
        Route::get('/profile/paid', [PaymentController::class, 'view'])->name('initiatePayment');
        Route::get('/tickets/{id}', [ProfileController::class, 'viewTickets'])->name('profile.tickets');
        Route::get('/cancel/{id}', [PaymentController::class, 'cancelOrder'])->name('profile.cancel');
    });
    
    Route::prefix('/winners')->middleware(CheckUserTokenMiddleware::class)->group(function(){
        Route::get('/', [WinnerController::class, 'view'])->name('winners.view');
    });

    Route::prefix('/admin')->group(function(){
        Route::get('/login', [AuthController::class, 'view'])->name('auth.view');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    });
});

Route::group(['middleware' => 'auth'], function (){
    Route::prefix('/admin')->group(function(){
        Route::get('/', [AdminController::class, 'view'])->name('admin.home');
        Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/discount', [AdminController::class, 'viewDiscount'])->name('admin.discount');
        Route::post('/discount/create', [AdminController::class, 'createDiscount'])->name('admin.discount.create');
        Route::post('/discount/generate-code', [AdminController::class, 'generateCode'])->name('admin.discount.generate.code');
        Route::delete('/discount/delete/{id}', [AdminController::class, 'deleteDiscount'])->name('admin.discount.delete');
        Route::get('/pool', [PoolController::class, 'view'])->name('admin.pool.view');
        Route::post('/pool/create', [PoolController::class, 'store'])->name('admin.pool.store');
        Route::match(['get', 'post'], '/pool/status/{id}', [PoolController::class, 'changeStatus'])->name('admin.pool.status');
        Route::match(['get', 'delete'],'/pool/delete/{id}', [PoolController::class, 'deletePool'])->name('admin.pool.delete');
        Route::post('/order/activate/{id}', [AdminController::class, 'activateOrder'])->name('admin.order.activate');
        Route::post('/order/cancel/{id}', [AdminController::class, 'cancelOrder'])->name('admin.order.cancel');
        Route::match(['get', 'post'], '/pick/winner', [AdminController::class, 'getWinner'])->name('admin.pick.winner');
    });
});
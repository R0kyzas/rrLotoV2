<?php

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
});

Route::middleware(CheckUserTokenMiddleware::class)->get('/profile', [UserController::class, 'view'])->name('profile');

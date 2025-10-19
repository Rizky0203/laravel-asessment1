<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// Pastikan BookingController di-import dan routes di bawahnya sama persis
Route::get('/', [BookingController::class, 'index'])->name('booking.form');
Route::post('/order', [BookingController::class, 'store'])->name('booking.store');
Route::get('/payment/{orderId}', [BookingController::class, 'payment'])->name('booking.payment');
Route::get('/confirm-payment/{orderId}', [BookingController::class, 'confirm'])->name('booking.confirm');

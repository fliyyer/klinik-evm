<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BookingSlotController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin/services')->name('admin.services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::patch('/{service}/toggle', [ServiceController::class, 'toggle'])->name('toggle');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/bookings')->name('admin.bookings.')->group(function () {
        Route::get('/', [BookingSlotController::class, 'index'])->name('index');
        Route::get('/create', [BookingSlotController::class, 'create'])->name('create');
        Route::post('/', [BookingSlotController::class, 'store'])->name('store');
        Route::get('/{booking}/edit', [BookingSlotController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingSlotController::class, 'update'])->name('update');
        Route::delete('/{booking}', [BookingSlotController::class, 'destroy'])->name('destroy');
    });

    Route::get('/admin/transactions', [TransactionController::class, 'index'])
        ->name('admin.transactions.index');

    Route::get('/admin/reports', [ReportController::class, 'index'])
        ->name('admin.reports.index');
    Route::get('/admin/reports/preview', [ReportController::class, 'preview'])
        ->name('admin.reports.preview');

    Route::prefix('user/bookings')->name('user.bookings.')->group(function () {
        Route::get('/', [UserBookingController::class, 'index'])->name('index');
        Route::get('/create', [UserBookingController::class, 'create'])->name('create');
        Route::post('/', [UserBookingController::class, 'store'])->name('store');
        Route::get('/{booking}/invoice', [UserBookingController::class, 'invoice'])->name('invoice');
    });
});

require __DIR__.'/auth.php';

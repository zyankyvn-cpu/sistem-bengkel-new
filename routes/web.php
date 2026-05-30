<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', fn() => redirect('/login'));

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/activity-feed', [DashboardController::class, 'activityFeed'])->name('dashboard.activity-feed');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('kendaraan', KendaraanController::class);
        Route::resource('sparepart', SparepartController::class);
        Route::resource('mekanik', MekanikController::class);
    });

    Route::middleware(['role:Admin,Kasir'])->group(function () {
        // parameter eksplisit 'servis' biar tidak jadi {servi}
        Route::resource('servis', ServisController::class)->parameters([
            'servis' => 'servis'
        ]);
    });

    Route::middleware(['role:Admin,Kasir'])->group(function () {
        Route::resource('pembayaran', PembayaranController::class);
    });

    Route::middleware(['role:Admin|Owner'])->group(function () {
    Route::get('/laporan',               [LaporanController::class, 'index'])       ->name('laporan.index');
    Route::get('/laporan/export/pdf',    [LaporanController::class, 'exportPdf'])   ->name('laporan.export.pdf');
    Route::get('/laporan/export/excel',  [LaporanController::class, 'exportExcel']) ->name('laporan.export.excel');
});

});
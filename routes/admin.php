<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\System\SettingController;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'auth.login']);
});

Route::middleware('auth:admin')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, '__invoke'])->name('dashboard');

    Route::middleware('can:manage-settings')->group(function () {
        Route::resource('settings', SettingController::class)->except(['show']);
        Route::post('settings/cache/clear', [SettingController::class, 'clearCache'])->name('settings.clear');
    });
});

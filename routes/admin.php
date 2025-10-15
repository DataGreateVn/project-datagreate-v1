<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\System\SettingController;
use App\Http\Controllers\Admin\System\TranslationController;

Route::middleware('guest:admin')->group(function () {
    Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware('auth:admin')->group(function () {
    // ==== CẤU HÌNH (gộp Settings + Translations)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index'); // redirect về section mặc định
    Route::get('settings/{section?}', [SettingController::class, 'section'])
        ->where('section', '[A-Za-z0-9\-\_]+')
        ->name('settings.section');

    Route::post('settings/bulk',  [SettingController::class, 'bulkSave'])->name('settings.bulk');
    Route::post('settings/clear', [SettingController::class, 'clearCache'])->name('settings.clear');

    // Translations CRUD (dùng trong phần "translations" của trang cấu hình)
    Route::resource('translations', TranslationController::class)->except(['show'])->names('translations');
    Route::post('translations/clear', [TranslationController::class, 'clearCache'])->name('translations.clear');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/',       [DashboardController::class, 'index'])->name('dashboard');
});

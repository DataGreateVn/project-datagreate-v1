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

    // ===== Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('permission:view-dashboard')
        ->name('dashboard');

    // ===== SETTINGS SHELL (mở khung giao diện, ai có 1 trong 2 quyền đều vào được)
    Route::get('settings', [SettingController::class, 'index'])
        ->middleware('role_or_permission:manage-settings|manage-translations')
        ->name('settings.index');

    Route::get('settings/{section?}', [SettingController::class, 'section'])
        ->where('section', '[A-Za-z0-9\-\_]+')
        ->middleware('role_or_permission:manage-settings|manage-translations')
        ->name('settings.section');

    // ===== SETTINGS ACTIONS (chỉ ai có manage-settings mới được)
    Route::post('settings/bulk',  [SettingController::class, 'bulkSave'])
        ->middleware('permission:manage-settings')
        ->name('settings.bulk');

    Route::post('settings/clear', [SettingController::class, 'clearCache'])
        ->middleware('permission:manage-settings')
        ->name('settings.clear');

    // ===== TRANSLATIONS CRUD (chỉ ai có manage-translations)
    Route::middleware('permission:manage-translations')->group(function () {
        Route::resource('translations', TranslationController::class)
            ->except(['show'])
            ->names('translations');

        Route::post('translations/clear', [TranslationController::class, 'clearCache'])
            ->name('translations.clear');
    });

    // ===== Auth
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

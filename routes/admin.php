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
    // Settings CRUD + clear cache
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::resource('settings', SettingController::class)
        ->except(['show'])         // index, create, store, edit, update, destroy
        ->names('settings');       // => admin.settings.*
    Route::post('settings/clear', [SettingController::class, 'clearCache'])
        ->name('settings.clear');

    // Translations CRUD + clear cache
    Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::resource('translations', TranslationController::class)
        ->except(['show'])->names('translations');
    Route::post('translations/clear', [TranslationController::class, 'clearCache'])
        ->name('translations.clear');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/',       [DashboardController::class, 'index'])->name('dashboard');
});

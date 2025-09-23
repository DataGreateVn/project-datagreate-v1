<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// Khách (chưa đăng nhập admin)
Route::middleware('guest:admin')->group(function () {
    // GET form login (dùng cho redirectTo -> route('admin.login'))
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    // POST submit form (trùng với action trong form: route('admin.auth.login'))
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
});

// Đã đăng nhập admin
Route::middleware('auth:admin')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Identity\AuthController as UserAuth;
use App\Http\Controllers\Api\Identity\AdminAuthController as AdminAuth;
use App\Http\Controllers\Api\System\SettingApiController;

// User API auth
Route::post('/auth/login', [UserAuth::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [UserAuth::class, 'me']);
    Route::post('/auth/logout', [UserAuth::class, 'logout']);
});

// Admin API auth (token-based)
Route::post('/admin/auth/login', [AdminAuth::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/auth/me', [AdminAuth::class, 'me']);
    Route::post('/admin/auth/logout', [AdminAuth::class, 'logout']);
});

// Public settings
Route::get('/settings', [SettingApiController::class, 'index']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Identity\AuthController;
use App\Http\Controllers\Api\V1\System\SettingApiController;
use App\Http\Controllers\Api\V1\System\TranslationApiController;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login',  [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me',     [AuthController::class, 'me']);

        Route::apiResource('translations', TranslationApiController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    // Settings public (lọc theo whitelist)
    Route::get('/settings', [SettingApiController::class, 'index']);
});

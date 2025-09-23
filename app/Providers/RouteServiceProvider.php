<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Web
        Route::middleware('web')->group(base_path('routes/web.php'));

        // API
        Route::prefix('api')->middleware('api')->group(base_path('routes/api.php'));

        // Admin
        Route::middleware('web')
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }
}

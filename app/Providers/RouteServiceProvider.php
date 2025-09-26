<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // API
        Route::prefix('api')->middleware('api')
            ->group(base_path('routes/api.php'));

        // WEB
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // ADMIN (không gắn auth để không chặn /admin/login)
        if (file_exists(base_path('routes/admin.php'))) {
            Route::prefix('admin')->name('admin.')->middleware('web')
                ->group(base_path('routes/admin.php'));
        }
    }
}

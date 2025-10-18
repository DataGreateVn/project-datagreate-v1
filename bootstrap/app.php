<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            // Nạp ADMIN TRƯỚC để không bị wildcard của web “nuốt”
            if (file_exists(base_path('routes/admin.php'))) {
                Route::middleware('web')
                    ->prefix('admin')->name('admin.')
                    ->group(base_path('routes/admin.php'));
            }
        },
        web: base_path('routes/web.php'),
        api: base_path('routes/api.php'),
        commands: base_path('routes/console.php'),
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Đăng ký alias (cái bạn đang có)
        $middleware->alias([
            'auth'  => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            // (tuỳ chọn) Spatie Permission:
            'role'       => \Spatie\Permission\Middlewares\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
            'roles_or_permissions' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        ]);

        // ✅ Thêm SetLocale vào NHÓM web (chạy cho tất cả route web + /admin)
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SetLocale::class,
        ]);

        // (Nếu muốn chạy cho tất cả request, kể cả api) dùng:
        // $middleware->use([\App\Http\Middleware\SetLocale::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();

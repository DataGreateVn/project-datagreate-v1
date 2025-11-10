<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            // 🚩 Nạp ROUTES ADMIN TRƯỚC để không bị web “nuốt”
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
        /**
         * ===== Aliases cơ bản =====
         */
        $middleware->alias([
            'auth'  => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        /**
         * ===== Spatie\Permission middlewares =====
         *  Một số phiên bản dùng namespace "Middlewares", một số dùng "Middleware".
         *  Đoạn dưới tự phát hiện để alias chính xác, tránh lỗi:
         *  Target class [Spatie\Permission\Middlewares\PermissionMiddleware] does not exist.
         */
        $nsPlural   = '\Spatie\Permission\Middlewares';
        $nsSingular = '\Spatie\Permission\Middleware';

        $usingNs = null;
        if (class_exists($nsPlural . '\PermissionMiddleware')) {
            $usingNs = $nsPlural;
        } elseif (class_exists($nsSingular . '\PermissionMiddleware')) {
            $usingNs = $nsSingular;
        }

        if ($usingNs) {
            $middleware->alias([
                'role'               => $usingNs . '\RoleMiddleware',
                'permission'         => $usingNs . '\PermissionMiddleware',
                'role_or_permission' => $usingNs . '\RoleOrPermissionMiddleware',
            ]);
        }

        /**
         * ===== Locale middleware cho tất cả routes web (kể cả /admin) =====
         */
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Breadcrumbs
{
    public static function make(): array
    {
        $current = Route::current();
        if (!$current) return [];

        $name   = $current->getName();           // ví dụ: admin.settings.index
        $parts  = $name ? explode('.', $name) : [];
        // Cấu trúc mong đợi: [admin, module, action]
        $module = $parts[1] ?? null;
        $action = $parts[2] ?? null;

        // Map label cho module
        $labels = [
            'dashboard'    => 'Dashboard',
            'settings'     => 'Settings',
            'translations' => 'Translations',
        ];

        $items = [];

        // 1) Home (Dashboard) luôn đứng đầu
        $items[] = [
            'label' => 'Home',
            'url'   => route('admin.dashboard'),
        ];

        // 2) Module (nếu có)
        if ($module && isset($labels[$module])) {
            $moduleIndex = "admin.$module.index";
            $items[] = [
                'label' => $labels[$module],
                'url'   => Route::has($moduleIndex) ? route($moduleIndex) : null,
            ];
        }

        // 3) Action (create/edit) → chữ cuối, không link
        if ($action && $action !== 'index') {
            $suffix = match ($action) {
                'create' => 'Create',
                'edit'   => 'Edit',
                default  => Str::title($action),
            };
            $items[] = ['label' => $suffix, 'url' => null];
        }

        return $items;
    }
}

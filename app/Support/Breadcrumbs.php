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

        $name  = $current->getName();           // ví dụ: admin.settings.section.general
        $parts = $name ? explode('.', $name) : [];

        // Cấu trúc mong đợi: [admin, module, action, ...]
        $module = $parts[1] ?? null;
        $action = $parts[2] ?? null;

        // Nạp label module từ file riêng
        /** @var array<string,string> $labels */
        $labels = require base_path('app/Support/breadcrumb_labels.php');

        $items = [];

        // 1) Home (Dashboard)
        $items[] = [
            'label' => \t('admin.breadcrumbs.home', 'Home'),
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

        // 3) Action hoặc Section (không link)
        if ($action && $action !== 'index') {
            if ($action === 'section') {
                // Dạng: admin.settings.section.{slug}
                $slug = $parts[3] ?? null;
                if ($slug) {
                    $items[] = [
                        'label' => \t("admin.settings.section.$slug", Str::title($slug)),
                        'url'   => null,
                    ];
                } else {
                    $items[] = [
                        'label' => \t('admin.breadcrumbs.section', 'Section'),
                        'url'   => null,
                    ];
                }
            } else {
                $suffix = match ($action) {
                    'create' => \t('admin.breadcrumbs.create', 'Create'),
                    'edit'   => \t('admin.breadcrumbs.edit', 'Edit'),
                    default  => Str::title($action),
                };
                $items[] = ['label' => $suffix, 'url' => null];
            }
        }

        return $items;
    }
}

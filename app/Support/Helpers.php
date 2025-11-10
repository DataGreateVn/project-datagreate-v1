<?php

use Illuminate\Support\Facades\Cache;
use App\Models\Translation;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

if (! function_exists('setting')) {
    function setting(?string $key, $default = null)
    {
        if (!$key) return $default;
        // bạn đã có Setting::getVal(...)
        if (class_exists(Setting::class) && method_exists(Setting::class, 'getVal')) {
            return Setting::getVal($key, $default);
        }
        return $default;
    }
}

if (! function_exists('app_locale')) {
    function app_locale(): string
    {
        return app()->getLocale() ?: config('app.locale', 'vi');
    }
}

if (! function_exists('t')) {
    /**
     * t('admin.auth_login.page_title', 'Data Greate Admin — Đăng nhập', ['name'=>'...'])
     */
    function t(string $dotKey, ?string $default = null, array $replacements = []): string
    {
        // dotKey = namespace.group.key
        $parts = explode('.', $dotKey);
        if (count($parts) < 3) {
            return $default ?? $dotKey;
        }
        [$namespace, $group] = array_slice($parts, 0, 2);
        $key = implode('.', array_slice($parts, 2));
        $locale = app_locale();

        $dict = Cache::remember("i18n:$locale:$namespace:$group", now()->addDay(), function () use ($locale, $namespace, $group) {
            return Translation::query()
                ->where('locale', $locale)
                ->where('namespace', $namespace)
                ->where('group', $group)
                ->pluck('value', 'key')
                ->toArray();
        });

        $text = $dict[$key] ?? $default ?? $dotKey;

        if (!empty($replacements)) {
            foreach ($replacements as $k => $v) {
                $text = str_replace([':{' . $k . '}', '{' . $k . '}'], (string)$v, $text);
            }
        }

        return $text;
    }
}

if (! function_exists('admin_menu_items')) {
    function admin_menu_items(): array
    {
        $path = config_path('admin_menu.json');
        if (! File::exists($path)) {
            return [];
        }
        $json = File::get($path);
        $items = json_decode($json, true);
        return is_array($items) ? $items : [];
    }
}

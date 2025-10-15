<?php

use App\Support\Locale;

if (! function_exists('setting')) {
    function setting(string $name, $default = null)
    {
        try {
            return cache()->remember("setting:$name", 60, function () use ($name, $default) {
                return optional(\App\Models\Setting::where('name', $name)->first())->val ?? $default;
            });
        } catch (\Throwable $e) {
            // phòng trường hợp cache không hoạt động
            return optional(\App\Models\Setting::where('name', $name)->first())->val ?? $default;
        }
    }
}

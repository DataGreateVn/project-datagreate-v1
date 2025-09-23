<?php

namespace App\Services\System;

use App\Models\Setting;

class SettingService
{
    public function get(string $name, $default = null)
    {
        return cache()->tags(['settings'])->remember("settings:$name", 3600, function () use ($name, $default) {
            $row = Setting::where('name', $name)->first();
            return $row?->val ?? $default;
        });
    }
    public function clearCache(): void
    {
        cache()->tags(['settings'])->flush();
    }
}

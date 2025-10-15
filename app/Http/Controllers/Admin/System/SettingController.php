<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.settings.section', config('admin_settings.default', 'general'));
    }

    public function section(Request $request, ?string $section = null)
    {
        $cfg     = config('admin_settings');
        $groups  = $cfg['groups'];
        $default = $cfg['default'] ?? 'general';

        $slugs   = collect($groups)->flatMap(fn($g) => collect($g['items'])->pluck('slug'))->all();
        $current = ($section && in_array($section, $slugs, true)) ? $section : $default;

        $partial = "admin.system.settings.sections.$current";
        if (! View::exists($partial)) {
            $partial = "admin.system.settings.sections._blank";
        }

        return view('admin.system.settings.shell', compact('groups', 'current', 'partial'));
    }

    // Lưu nhiều key 1 lần
    public function bulkSave(Request $request)
    {
        $data = $request->input('settings', []);
        foreach ($data as $name => $val) {
            Setting::updateOrCreate(['name' => $name], ['val' => $val]);
        }

        $this->flushSettingsCache();

        return back()->with('ok', 'Đã lưu cài đặt');
    }

    public function clearCache()
    {
        $this->flushSettingsCache();
        return back()->with('ok', 'Đã xoá cache settings');
    }

    /**
     * Xoá cache settings an toàn cho mọi cache driver (kể cả không hỗ trợ tag).
     */
    private function flushSettingsCache(): void
    {
        // Nếu bạn có helper setting_flush_cache() (đã gửi trước đó) thì dùng:
        if (function_exists('setting_flush_cache')) {
            setting_flush_cache();
            return;
        }

        // Fallback nếu chưa có helper:
        try {
            // thử flush theo tag
            cache()->tags(['settings'])->flush();
        } catch (\Throwable $e) {
            // store không hỗ trợ tag -> forget từng key "settings:{name}"
            $repo  = Cache::store(config('cache.default'));
            $names = Setting::query()->pluck('name')->all();
            foreach ($names as $n) {
                $repo->forget("settings:$n");
            }
            // nếu bạn từng cache theo prefix, có thể xoá thêm các key prefix ở đây
        }
    }
}

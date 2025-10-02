<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Requests\System\SettingUpsertRequest;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $q = request('q');
        $settings = Setting::when($q, fn($qq) => $qq->where('name', 'like', "%$q%"))
            ->orderBy('name')
            ->paginate(20);

        return view('admin.system.settings.index', compact('settings', 'q'));
    }

    public function create()
    {
        return view('admin.system.settings.form', ['setting' => new Setting()]);
    }

    public function store(SettingUpsertRequest $r)
    {
        Setting::create($r->validated());
        $this->clearSettingsCache();
        return redirect()->route('admin.settings.index')->with('ok', 'Created');
    }

    public function edit(Setting $setting)
    {
        return view('admin.system.settings.form', compact('setting'));
    }

    public function update(SettingUpsertRequest $r, Setting $setting)
    {
        $setting->update($r->validated());
        $this->clearSettingsCache();
        return redirect()->route('admin.settings.index')->with('ok', 'Updated');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        $this->clearSettingsCache();
        return back()->with('ok', 'Deleted');
    }

    public function clearCache()
    {
        $this->clearSettingsCache();
        return back()->with('ok', 'Cache cleared');
    }

    private function clearSettingsCache(): void
    {
        // KHÔNG dùng tags -> chỉ forget đúng key đang dùng ở service
        Cache::forget('settings:kv');
    }
}

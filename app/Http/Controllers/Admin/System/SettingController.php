<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\System\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $r)
    {
        $q = Setting::query()->when($r->name, fn($x) => $x->where('name', 'like', "%{$r->name}%"))->orderBy('name');
        $settings = $q->paginate(20);
        return view('admin.system.settings.index', compact('settings'));
    }
    public function store(Request $r)
    {
        $r->validate(['name' => 'required|max:190', 'val' => 'nullable']);
        Setting::create($r->only('name', 'val'));
        app(SettingService::class)->clearCache();
        return back()->with('ok', true);
    }
    public function update(Request $r, Setting $setting)
    {
        $r->validate(['name' => 'required|max:190', 'val' => 'nullable']);
        $setting->update($r->only('name', 'val'));
        app(SettingService::class)->clearCache();
        return back()->with('ok', true);
    }
    public function destroy(Setting $setting)
    {
        $setting->delete();
        app(SettingService::class)->clearCache();
        return back()->with('ok', true);
    }
    public function clearCache(SettingService $svc)
    {
        $svc->clearCache();
        return back()->with('ok', true);
    }
}

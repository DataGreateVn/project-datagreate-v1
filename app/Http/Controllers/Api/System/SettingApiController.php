<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\SettingUpsertRequest;
use App\Services\System\SettingsService;
use Illuminate\Http\Request;

class SettingApiController extends Controller
{
    public function __construct(private SettingsService $settings) {}

    // Public: trả về toàn bộ (có thể lọc whitelist tùy nhu cầu)
    public function index()
    {
        return response()->json($this->settings->all());
    }

    // Public: lấy 1 key (có cache riêng)
    public function show(string $name)
    {
        return response()->json([
            'name' => $name,
            'val'  => $this->settings->getOneCached($name),
        ]);
    }

    // Admin: upsert 1 cặp name-val (ủy quyền qua FormRequest)
    public function upsert(SettingUpsertRequest $request)
    {
        $data = $request->validated();
        $saved = $this->settings->set($data['name'], $data['val'] ?? null);

        return response()->json([
            'ok'   => true,
            'data' => $saved,
        ]);
    }
}

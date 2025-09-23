<?php

namespace App\Http\Controllers\Api\V1\System;

use App\Http\Controllers\Controller;
use App\Services\System\SettingService;

class SettingApiController extends Controller
{
    public function index(SettingService $svc)
    {
        // whitelist keys công khai
        $keys = ['site.name', 'site.locale_default', 'seo.index'];
        $data = [];
        foreach ($keys as $k) {
            $data[$k] = $svc->get($k);
        }
        return response()->json($data);
    }
}

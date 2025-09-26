<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingApiController extends Controller
{
    public function index()
    {
        // whitelist keys public
        $publicPrefixes = ['site.', 'theme.', 'seo.'];
        $items = Setting::query()
            ->where(function ($q) use ($publicPrefixes) {
                foreach ($publicPrefixes as $p) $q->orWhere('name', 'like', "$p%");
            })->get(['name', 'val']);

        return $items->map(fn($s) => [
            'name' => $s->name,
            'val' => $s->val,
        ]);
    }
}

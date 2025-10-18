<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $lang = $request->query('lang');

        if ($lang && in_array($lang, ['vi', 'en'])) {
            session(['locale' => $lang]);
            cookie()->queue(cookie('locale', $lang, 60 * 24 * 30)); // 30 ngày
        }

        $locale = session('locale') ?: ($request->cookie('locale') ?: config('app.locale', 'vi'));
        if (! in_array($locale, ['vi', 'en'])) {
            $locale = 'vi';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}

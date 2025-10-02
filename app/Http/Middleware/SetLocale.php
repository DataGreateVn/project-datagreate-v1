<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->query('lang')
            ?? $request->header('X-Locale')
            ?? app()->getLocale();

        if (is_string($locale) && preg_match('/^[a-zA-Z_-]{2,5}$/', $locale)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminLocale
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale($request->query('lang', 'vi'));
        return $next($request);
    }
}

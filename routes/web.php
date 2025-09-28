<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// ... các route web khác ...

// Nếu là SPA/wildcard: đặt CUỐI CÙNG và loại trừ admin|api
Route::get('{any}', fn() => view('welcome'))
    ->where('any', '^(?!admin|api)(.*)$');
// hoặc: Route::fallback(fn () => view('welcome'));

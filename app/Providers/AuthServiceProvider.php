<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        \App\Models\Setting::class => \App\Policies\SettingPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

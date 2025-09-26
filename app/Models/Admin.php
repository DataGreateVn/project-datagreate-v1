<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles; // 👈 thêm HasApiTokens

    protected $guard_name = 'admin';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token', 'google2fa_secret'];
    protected $casts  = [
        'email_verified_at' => 'datetime',
        'google2fa_ts' => 'datetime',
        'two_factor_enabled' => 'boolean',
    ];
}

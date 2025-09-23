<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
// use Laravel\Sanctum\HasApiTokens; // BẬT nếu muốn admin có thể tạo API token qua Sanctum

class Admin extends Authenticatable
{
    use SoftDeletes, Notifiable, HasRoles; // , HasApiTokens

    /**
     * Guard mặc định cho Spatie Permission
     * (rất quan trọng khi có nhiều guard).
     */
    protected $guard_name = 'admin';

    /**
     * Cho phép mass-assign mọi cột (cân nhắc nếu bạn muốn chặt chẽ hơn).
     * Hoặc thay bằng $fillable = ['name','email','password', ...];
     */
    protected $guarded = [];

    /**
     * Ẩn các trường nhạy cảm khỏi array/json.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * Ép kiểu các cột.
     */
    protected $casts = [
        'password'           => 'hashed',   // Laravel sẽ tự hash khi set
        'email_verified_at'  => 'datetime',
        'google2fa_ts'       => 'datetime',
        'two_factor_enabled' => 'boolean',
    ];
}

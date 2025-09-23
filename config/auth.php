<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mặc định xác thực (Authentication Defaults)
    |--------------------------------------------------------------------------
    |
    | Ở đây định nghĩa guard mặc định và broker reset password mặc định.
    | Bạn có thể thay đổi nếu cần, nhưng thông thường giá trị này là đủ.
    |
    */

    'defaults' => ['guard' => 'web', 'passwords' => 'users'],

    /*
    |--------------------------------------------------------------------------
    | Các Guard xác thực (Authentication Guards)
    |--------------------------------------------------------------------------
    |
    | Tại đây bạn định nghĩa các guard để xác thực người dùng.
    | Mặc định Laravel đã cấu hình sẵn guard "web" và "api".
    |
    | - "driver": cách thức lưu trạng thái đăng nhập (session, token...)
    | - "provider": cách lấy thông tin user (từ model nào, bảng nào).
    |
    | Hỗ trợ: "session", "token" (hoặc sanctum, passport tuỳ cài đặt).
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Các Provider người dùng (User Providers)
    |--------------------------------------------------------------------------
    |
    | Provider quy định cách lấy thông tin người dùng từ database hoặc nguồn khác.
    | Thông thường sẽ dùng "eloquent" (Model) hoặc "database" (truy vấn bảng).
    |
    | Bạn có thể tạo nhiều provider nếu có nhiều bảng user khác nhau
    | (ví dụ bảng users cho khách hàng, bảng admins cho quản trị viên).
    |
    */

    'providers' => [
        'users'  => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Reset mật khẩu (Resetting Passwords)
    |--------------------------------------------------------------------------
    |
    | Cấu hình chức năng reset mật khẩu:
    | - provider: dùng model/bảng nào để tìm user
    | - table: bảng lưu token reset
    | - expire: thời gian (phút) mà token còn hiệu lực
    |
    | Ngoài ra có "throttle" (nếu muốn) để giới hạn số lần yêu cầu token reset.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Timeout xác nhận mật khẩu (Password Confirmation Timeout)
    |--------------------------------------------------------------------------
    |
    | Số giây trước khi phiên xác nhận mật khẩu hết hạn.
    | Sau thời gian này, hệ thống sẽ yêu cầu nhập lại mật khẩu.
    | Mặc định là 10800 giây (3 giờ).
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];

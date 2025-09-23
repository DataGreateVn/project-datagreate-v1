<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Có thể cấu hình qua ENV cho tiện đổi ở từng môi trường
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPass  = env('ADMIN_PASSWORD', 'ChangeMe123!');

        // Tạo role + permissions cho guard 'admin'
        $role = Role::findOrCreate('super-admin', 'admin');

        $corePerms = ['manage-users', 'manage-settings', 'view-reports'];
        foreach ($corePerms as $p) {
            Permission::findOrCreate($p, 'admin');
        }

        // Đồng bộ toàn bộ permission cho role (idempotent, gọn hơn givePermissionTo)
        $role->syncPermissions(Permission::where('guard_name', 'admin')->pluck('name')->toArray());

        // Tạo/ cập nhật admin mặc định
        $admin = Admin::updateOrCreate(
            ['email' => $adminEmail],
            ['name' => 'Super Admin', 'password' => Hash::make($adminPass)]
        );

        // Gán role (an toàn nếu chạy nhiều lần)
        if (! $admin->hasRole($role->name)) {
            $admin->assignRole($role);
        }

        // Xoá cache permission của Spatie (tránh kẹt cache)
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

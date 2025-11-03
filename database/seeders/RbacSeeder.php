<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Admin;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        // reset cache permission để tránh lưu cũ
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // ==== Định nghĩa permissions chuẩn của bạn ====
        $perms = [
            // hệ thống
            'view-dashboard',
            'manage-settings',
            'manage-translations',
            // có thể thêm:
            // 'manage-users', 'manage-roles', 'manage-products', ...
        ];
        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'admin']);
        }

        // ==== Roles ====
        $super  = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'content-admin', 'guard_name' => 'admin']);
        $transl = Role::firstOrCreate(['name' => 'translator', 'guard_name' => 'admin']);

        // gán quyền cho role
        $editor->syncPermissions(['view-dashboard', 'manage-settings']);
        $transl->syncPermissions(['view-dashboard', 'manage-translations']);

        // super-admin có tất cả quyền (cách 1: gán hết)
        $super->syncPermissions(Permission::pluck('name')->all());

        // (tuỳ chọn) gán role cho admin #1
        if ($admin = Admin::query()->first()) {
            $admin->assignRole('super-admin');
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

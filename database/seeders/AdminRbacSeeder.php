<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 🔄 Reset cache Spatie để tránh lỗi duplicate
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ===== 1. TẠO QUYỀN =====
        $permissions = [
            'view-dashboard',
            'manage-settings',
            'manage-translations',
        ];

        foreach ($permissions as $perm) {
            Permission::findOrCreate($perm, 'admin');
        }

        // ===== 2. TẠO ROLE =====
        $roles = [
            'super-admin' => ['view-dashboard', 'manage-settings', 'manage-translations'],
            'manager'     => ['view-dashboard', 'manage-settings'],
            'editor'      => ['view-dashboard'],
        ];

        foreach ($roles as $role => $perms) {
            $r = Role::findOrCreate($role, 'admin');
            $r->syncPermissions($perms);
        }

        // ===== 3. GÁN ROLE CHO ADMIN CỤ THỂ =====
        $assignments = [
            2 => 'super-admin',
            3 => 'manager',
            4 => 'editor',
        ];

        foreach ($assignments as $id => $role) {
            $admin = Admin::find($id);

            if (! $admin) {
                $admin = Admin::create([
                    'id' => $id,
                    'name' => "Admin {$id}",
                    'email' => "admin{$id}@example.com",
                    'password' => bcrypt('secret123'),
                ]);
            }

            $admin->syncRoles([$role]);
        }

        // ✅ Xác nhận hoàn tất
        $this->command->info('✅ Admin RBAC setup done: roles, permissions & assignments created.');
    }
}

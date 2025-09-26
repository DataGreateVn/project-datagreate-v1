<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // role cho guard 'admin'
        $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);

        $admin = Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Administrator', 'password' => Hash::make('admin@gmail.com')]
        );

        if (! $admin->hasRole('super-admin')) {
            $admin->assignRole($role);
        }
    }
}

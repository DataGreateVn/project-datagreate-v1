<?php

namespace App\Policies;

use App\Models\Admin;

class SettingPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('manage-settings');
    }
    public function view(Admin $admin): bool
    {
        return $admin->can('manage-settings');
    }
    public function create(Admin $admin): bool
    {
        return $admin->can('manage-settings');
    }
    public function update(Admin $admin): bool
    {
        return $admin->can('manage-settings');
    }
    public function delete(Admin $admin): bool
    {
        return $admin->can('manage-settings');
    }
}

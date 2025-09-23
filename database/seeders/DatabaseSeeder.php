<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    // use \Illuminate\Database\Console\Seeds\WithoutModelEvents; // nếu muốn bỏ qua events

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
        ]);

        // Dev-only seeds
        if (app()->environment(['local', 'development', 'staging'])) {
            User::updateOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'password' => Hash::make('ChangeMe123!'), // đổi khi cần
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $pairs = [
            'site.name' => 'DataGreate Việt Nam',
            'site.url'  => 'https://datagreate.vn',
            'mail.from' => ['address' => 'no-reply@datagreate.vn', 'name' => 'DataGreate'],
            'ui.theme'  => ['primary' => '#0ea5e9', 'secondary' => '#111827'],
        ];

        foreach ($pairs as $k => $v) {
            Setting::updateOrCreate(['name' => $k], ['val' => $v]);
        }
    }
}

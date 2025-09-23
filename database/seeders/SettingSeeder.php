<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'site.name'          => 'Datagreate',
            'site.locale_default' => 'vi',
            'seo.index'          => true, // sẽ được cast nếu model hỗ trợ
        ];

        foreach ($items as $name => $val) {
            Setting::updateOrCreate(
                ['name' => $name],
                ['val'  => $val]
            );
        }
    }
}

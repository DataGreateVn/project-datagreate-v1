<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use App\Models\Translation;

class TranslationLayoutSeeder extends Seeder
{
    public function run(): void
    {
        $namespace = 'admin';
        $group     = 'layout';

        $rows = [
            // ===== VI =====
            ['vi', $namespace, $group, 'page_title', 'Admin'],
            ['vi', $namespace, $group, 'skip_nav', 'Bỏ qua nội dung điều hướng'],

            // menu
            ['vi', $namespace, $group, 'menu_dashboard', 'Bảng điều khiển'],
            ['vi', $namespace, $group, 'menu_settings', 'Cài đặt'],
            ['vi', $namespace, $group, 'menu_translations', 'Bản dịch'],

            // user/footer
            ['vi', $namespace, $group, 'user_avatar_initial', 'A'],
            ['vi', $namespace, $group, 'user_display_name', 'Admin'],
            ['vi', $namespace, $group, 'change_password', 'Đổi mật khẩu'],
            ['vi', $namespace, $group, 'logout', 'Đăng xuất'],

            // language
            ['vi', $namespace, $group, 'language', 'Ngôn ngữ'],
            ['vi', $namespace, $group, 'language_menu', 'Trình đơn ngôn ngữ'],
            ['vi', $namespace, $group, 'lang_vietnamese', 'Tiếng Việt'],
            ['vi', $namespace, $group, 'lang_english', 'English'],

            // topbar
            ['vi', $namespace, $group, 'open_menu', 'Mở menu'],

            // ===== EN =====
            ['en', $namespace, $group, 'page_title', 'Admin'],
            ['en', $namespace, $group, 'skip_nav', 'Skip navigation'],

            ['en', $namespace, $group, 'menu_dashboard', 'Dashboard'],
            ['en', $namespace, $group, 'menu_settings', 'Settings'],
            ['en', $namespace, $group, 'menu_translations', 'Translations'],

            ['en', $namespace, $group, 'user_avatar_initial', 'A'],
            ['en', $namespace, $group, 'user_display_name', 'Admin'],
            ['en', $namespace, $group, 'change_password', 'Change password'],
            ['en', $namespace, $group, 'logout', 'Sign out'],

            ['en', $namespace, $group, 'language', 'Language'],
            ['en', $namespace, $group, 'language_menu', 'Language menu'],
            ['en', $namespace, $group, 'lang_vietnamese', 'Vietnamese'],
            ['en', $namespace, $group, 'lang_english', 'English'],

            ['en', $namespace, $group, 'open_menu', 'Open menu'],
        ];

        // Chuẩn hoá dữ liệu cho upsert
        $values = array_map(function ($r) {
            [$locale, $namespace, $group, $key, $value] = $r;
            return [
                'locale'     => $locale,
                'namespace'  => $namespace,
                'group'      => $group,
                'key'        => $key,
                'value'      => $value,
                'updated_by' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ];
        }, $rows);

        // Upsert theo 4 cột định danh, cập nhật 'value' + 'updated_by' nếu đã tồn tại
        Translation::query()->upsert(
            $values,
            ['locale', 'namespace', 'group', 'key'],
            ['value', 'updated_by', 'updated_at']
        );

        // (Tuỳ chọn) clear cache i18n cho layout này nếu bạn có dùng cache theo key "i18n:{locale}:{ns}:{group}"
        foreach (['vi', 'en'] as $lo) {
            Cache::forget("i18n:{$lo}:{$namespace}:{$group}");
        }
    }
}

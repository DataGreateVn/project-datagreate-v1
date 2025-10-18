<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class TranslationLoginSeeder extends Seeder
{
    public function run(): void
    {
        $namespace = 'admin';
        $group     = 'auth_login';

        $rows = [
            // VI
            ['vi', $namespace, $group, 'page_title', 'Data Greate Admin — Đăng nhập'],
            ['vi', $namespace, $group, 'heading', 'Admin Portal'],
            ['vi', $namespace, $group, 'subheading', 'Đăng nhập để quản lý hệ thống'],
            ['vi', $namespace, $group, 'email_label', 'Email'],
            ['vi', $namespace, $group, 'email_placeholder', 'admin@datagreate.vn'],
            ['vi', $namespace, $group, 'password_label', 'Mật khẩu'],
            ['vi', $namespace, $group, 'password_placeholder', '••••••••'],
            ['vi', $namespace, $group, 'remember', 'Nhớ đăng nhập'],
            ['vi', $namespace, $group, 'submit', 'Đăng nhập'],
            ['vi', $namespace, $group, 'error_first', 'Thông tin đăng nhập không hợp lệ.'],
            ['vi', $namespace, $group, 'footer', '© :year Data Greate VN — Admin System'],
            ['vi', $namespace, $group, 'brand', 'Data Greate Admin'],

            // EN
            ['en', $namespace, $group, 'page_title', 'Data Greate Admin — Sign in'],
            ['en', $namespace, $group, 'heading', 'Admin Portal'],
            ['en', $namespace, $group, 'subheading', 'Sign in to manage the system'],
            ['en', $namespace, $group, 'email_label', 'Email'],
            ['en', $namespace, $group, 'email_placeholder', 'admin@datagreate.vn'],
            ['en', $namespace, $group, 'password_label', 'Password'],
            ['en', $namespace, $group, 'password_placeholder', '••••••••'],
            ['en', $namespace, $group, 'remember', 'Remember me'],
            ['en', $namespace, $group, 'submit', 'Sign in'],
            ['en', $namespace, $group, 'error_first', 'Invalid credentials.'],
            ['en', $namespace, $group, 'footer', '© :year Data Greate VN — Admin System'],
            ['en', $namespace, $group, 'brand', 'Data Greate Admin'],
        ];

        foreach ($rows as [$locale, $ns, $gr, $key, $value]) {
            Translation::updateOrCreate(
                [
                    'locale'    => $locale,
                    'namespace' => $ns,
                    'group'     => $gr,
                    'key'       => $key,
                ],
                [
                    'value'      => $value,
                    'updated_by' => 1,
                ]
            );
        }
    }
}

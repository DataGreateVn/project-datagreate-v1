<?php

return [
    'default' => 'general',

    'groups' => [
        [
            'label' => 'Cài đặt thông tin',
            'items' => [
                ['slug' => 'general',   'label' => 'Thông tin chung'],
                ['slug' => 'meta',      'label' => 'Meta'],
                ['slug' => 'robots',    'label' => 'Robots.txt'],
                ['slug' => 'redirects', 'label' => 'Redirects'],
                ['slug' => 'env',       'label' => 'Tuỳ chỉnh biến môi trường'],
            ],
        ],
        [
            'label' => 'Email',
            'items' => [
                ['slug' => 'smtp',          'label' => 'Cấu hình SMTP'],
                ['slug' => 'notifications', 'label' => 'Thông báo'],
            ],
        ],
        [
            'label' => 'Nội dung',
            'items' => [
                ['slug' => 'translations', 'label' => 'Translations (i18n)'],
            ],
        ],
    ],
];

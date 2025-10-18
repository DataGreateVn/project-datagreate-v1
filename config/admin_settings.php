<?php
// config/admin_settings_groups.php (hoặc nơi bạn đang trả ra mảng này)
return [
    'default' => 'general',

    'groups' => [
        [
            // dùng key dịch thay vì text
            'label_key' => 'admin.settings.group.info', // 'Cài đặt thông tin'
            'items' => [
                ['slug' => 'general',   'label_key' => 'admin.settings.sidebar.general'],
                ['slug' => 'meta',      'label_key' => 'admin.settings.sidebar.meta'],
                ['slug' => 'robots',    'label_key' => 'admin.settings.sidebar.robots'],
                ['slug' => 'redirects', 'label_key' => 'admin.settings.sidebar.redirects'],
                ['slug' => 'env',       'label_key' => 'admin.settings.sidebar.env'],
            ],
        ],
        [
            'label_key' => 'admin.settings.group.email', // 'Email'
            'items' => [
                ['slug' => 'smtp',          'label_key' => 'admin.settings.sidebar.smtp'],
                ['slug' => 'notifications', 'label_key' => 'admin.settings.sidebar.notifications'],
            ],
        ],
        [
            'label_key' => 'admin.settings.group.content', // 'Nội dung'
            'items' => [
                ['slug' => 'translations', 'label_key' => 'admin.settings.sidebar.translations'],
            ],
        ],
    ],
];

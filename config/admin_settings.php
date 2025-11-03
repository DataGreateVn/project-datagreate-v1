<?php
// config/admin_settings_groups.php
return [
    'default' => 'general',

    // map slug => permission
    'permissions_map' => [
        // mặc định cho các mục settings
        '*'             => 'manage-settings',
        // mục đặc thù
        'translations'  => 'manage-translations',
    ],

    'groups' => [
        [
            'label_key' => 'admin.settings.group.info',
            'items' => [
                ['slug' => 'general',   'label_key' => 'admin.settings.sidebar.general'],
                ['slug' => 'meta',      'label_key' => 'admin.settings.sidebar.meta'],
                ['slug' => 'robots',    'label_key' => 'admin.settings.sidebar.robots'],
                ['slug' => 'redirects', 'label_key' => 'admin.settings.sidebar.redirects'],
                ['slug' => 'env',       'label_key' => 'admin.settings.sidebar.env'],
            ],
        ],
        [
            'label_key' => 'admin.settings.group.email',
            'items' => [
                ['slug' => 'smtp',          'label_key' => 'admin.settings.sidebar.smtp'],
                ['slug' => 'notifications', 'label_key' => 'admin.settings.sidebar.notifications'],
            ],
        ],
        [
            'label_key' => 'admin.settings.group.content',
            'items' => [
                ['slug' => 'translations', 'label_key' => 'admin.settings.sidebar.translations'],
            ],
        ],
    ],
];

<?php

return [
    'defaults' => [
        'guard' => 'admin',    // dùng guard admin cho hệ thống RBAC của bạn
    ],
    // nếu bạn dùng cache file/database (không tagging) vẫn OK
    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => null, // để null dùng default cache store
    ],
];

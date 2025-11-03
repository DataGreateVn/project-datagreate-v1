<?php

return [
    // ...
    'default_guard' => 'admin',

    'guards' => [
        'admin', // dùng cùng với auth:admin
    ],

    // nếu bạn dùng cache file/database (không tagging) vẫn OK
    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => null, // để null dùng default cache store
    ],
];

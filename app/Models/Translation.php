<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    protected $fillable = [
        'locale',
        'namespace',
        'group',
        'key',
        'value',
        'updated_by',
    ];

    protected static function booted()
    {
        $forget = function (Translation $tr) {
            $key = "i18n:{$tr->locale}:{$tr->namespace}:{$tr->group}";
            Cache::forget($key);
        };

        static::saved($forget);
        static::deleted($forget);
    }
}

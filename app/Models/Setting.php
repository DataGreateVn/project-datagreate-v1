<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'val'];
    protected $casts = ['val' => 'array']; // nếu val là JSON

    // ---- Helpers ----
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['name' => $key], ['val' => $value]);
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::set($key, $value);
        }
    }
}

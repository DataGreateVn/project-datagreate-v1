<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\TagCache;

class Setting extends Model
{
    protected $fillable = ['name', 'val'];

    // Khi lấy ra: JSON -> array|scalar; text -> string; null -> null
    protected $casts = ['val' => 'array'];

    protected static function booted()
    {
        static::saved(fn() => self::clearCache());
        static::deleted(fn() => self::clearCache());
    }

    /**
     * Mutator: nhận null | text | JSON string | array/object
     * - JSON hợp lệ => lưu JSON
     * - Text => bọc thành JSON string
     */
    public function setValAttribute($value): void
    {
        if ($value === null || (is_string($value) && trim($value) === '')) {
            $this->attributes['val'] = null;
            return;
        }

        if (is_string($value)) {
            $trim = trim($value);
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['val'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
                return;
            }
            $this->attributes['val'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            return;
        }

        // mảng/đối tượng -> lưu JSON
        $this->attributes['val'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /** Map name => val (đã cache 1h) */
    public static function map(): array
    {
        return TagCache::remember('settings', 'map', 3600, function () {
            return self::query()
                ->orderBy('name')
                ->get(['name', 'val'])
                ->mapWithKeys(fn($row) => [$row->name => $row->val])
                ->toArray();
        }) ?? [];
    }

    /** Lấy 1 key nhanh */
    public static function getVal(string $name, $default = null)
    {
        $map = self::map();
        return $map[$name] ?? $default;
    }

    /** Clear cache tất cả settings */
    public static function clearCache(): void
    {
        TagCache::flush('settings');
    }

    /** Scope tìm kiếm */
    public function scopeSearch($q, ?string $term)
    {
        return $q->when($term, fn($qq) => $qq->where('name', 'like', "%{$term}%"));
    }
}

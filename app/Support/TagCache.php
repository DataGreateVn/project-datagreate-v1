<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class TagCache
{
    /**
     * Trả về true nếu store hỗ trợ tagging (redis, memcached).
     */
    protected static function supportsTags(): bool
    {
        $store = Cache::getStore();

        // Laravel 11: Redis/Memcached sẽ là TaggableStore
        return method_exists($store, 'tags') || $store instanceof \Illuminate\Cache\TaggableStore;
    }

    /**
     * Lấy version hiện tại của tag (dùng cho fallback khi store không hỗ trợ tags).
     */
    protected static function version(string $tag): int
    {
        $key = "tagver:{$tag}";
        return (int) (Cache::get($key, 1));
    }

    /**
     * Tăng version để "xóa cache theo tag" (fallback).
     */
    protected static function bump(string $tag): void
    {
        $key = "tagver:{$tag}";
        Cache::forever($key, self::version($tag) + 1);
    }

    /**
     * Tạo cache key có kèm version (fallback).
     */
    protected static function vkey(string $tag, string $key): string
    {
        return "{$tag}:v" . self::version($tag) . ":{$key}";
    }

    /**
     * Ghi nhớ value theo (tag, key) trong ttl (seconds).
     * Ưu tiên dùng tagging thật; fallback dùng key có version.
     */
    public static function remember(string $tag, string $key, int $ttlSeconds, \Closure $callback)
    {
        if (self::supportsTags()) {
            return Cache::tags([$tag])->remember($key, $ttlSeconds, $callback);
        }

        $vkey = self::vkey($tag, $key);
        return Cache::remember($vkey, $ttlSeconds, $callback);
    }

    /**
     * Xóa theo tag. Nếu store không hỗ trợ tags -> bump version.
     */
    public static function flush(string $tag): void
    {
        if (self::supportsTags()) {
            Cache::tags([$tag])->flush();
            return;
        }
        self::bump($tag); // vô hiệu hoá tất cả vkey cũ
    }

    /**
     * Xóa 1 key trong tag (nếu cần). Fallback: forget theo vkey hiện tại.
     */
    public static function forget(string $tag, string $key): void
    {
        if (self::supportsTags()) {
            Cache::tags([$tag])->forget($key);
            return;
        }
        Cache::forget(self::vkey($tag, $key));
    }
}

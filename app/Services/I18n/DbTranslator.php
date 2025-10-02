<?php

namespace App\Services\I18n;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DbTranslator
{
    protected function key(string $locale, string $namespace, string $group): string
    {
        return "i18n:{$locale}:{$namespace}:{$group}";
    }

    public function get(string $locale, string $namespace = '*', string $group = '*'): array
    {
        $cacheKey = $this->key($locale, $namespace, $group);

        return Cache::remember($cacheKey, 3600, function () use ($locale, $namespace, $group) {
            $q = DB::table('translations')->where('locale', $locale);

            if ($namespace !== '*') $q->where('namespace', $namespace);
            if ($group !== '*')     $q->where('group', $group);

            return $q->pluck('value', 'key')->toArray();
        });
    }

    public function set(
        string $locale,
        string $namespace,
        string $group,
        string $key,
        ?string $value,
        ?int $byAdminId = null
    ): void {
        DB::table('translations')->updateOrInsert(
            compact('locale', 'namespace', 'group', 'key'),
            ['value' => $value ?? '', 'updated_by' => $byAdminId, 'updated_at' => now()]
        );

        Cache::forget($this->key($locale, $namespace, $group));
    }
}

<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\TranslationUpsertRequest;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TranslationsApiController extends Controller
{
    private function key(string $locale, string $namespace, string $group): string
    {
        return "i18n:{$locale}:{$namespace}:{$group}";
    }

    /**
     * PUBLIC: fetch key=>value theo locale/group, ?namespace=*
     * GET /api/i18n/{locale}/{group?}?namespace=*
     */
    public function fetch(string $locale, ?string $group = null, Request $r)
    {
        $ns = $r->query('namespace', '*');
        $gr = $group ?: '*';
        $cacheKey = $this->key($locale, $ns, $gr);

        $data = Cache::remember($cacheKey, 3600, function () use ($locale, $ns, $gr) {
            $q = Translation::query()->where('locale', $locale);
            if ($ns !== '*') $q->where('namespace', $ns);
            if ($gr !== '*') $q->where('group', $gr);
            return $q->pluck('value', 'key')->toArray();
        });

        return response()->json($data);
    }

    // ADMIN: list + filter + paginate
    public function index(Request $r)
    {
        $q  = $r->string('q')->toString();
        $lo = $r->string('locale')->toString();
        $ns = $r->string('namespace')->toString();
        $gr = $r->string('group')->toString();

        $rows = Translation::when($lo, fn($x) => $x->where('locale', $lo))
            ->when($ns, fn($x) => $x->where('namespace', $ns))
            ->when($gr, fn($x) => $x->where('group', $gr))
            ->when($q,  fn($x) => $x->where(function ($w) use ($q) {
                $w->where('key', 'like', "%$q%")->orWhere('value', 'like', "%$q%");
            }))
            ->orderBy('locale')->orderBy('group')->orderBy('key')
            ->paginate($r->integer('per_page', 20));

        return response()->json($rows);
    }

    // ADMIN: create
    public function store(TranslationUpsertRequest $r)
    {
        $data = $r->validated();
        $data['updated_by'] = optional($r->user('admin'))->id;

        $row = Translation::create($data);
        Cache::forget($this->key($row->locale, $row->namespace, $row->group));

        return response()->json(['data' => $row], 201);
    }

    // ADMIN: update
    public function update(TranslationUpsertRequest $r, Translation $translation)
    {
        $translation->fill($r->validated());
        $translation->updated_by = optional($r->user('admin'))->id;
        $translation->save();

        Cache::forget($this->key($translation->locale, $translation->namespace, $translation->group));

        return response()->json(['data' => $translation]);
    }

    // ADMIN: delete
    public function destroy(Translation $translation)
    {
        Cache::forget($this->key($translation->locale, $translation->namespace, $translation->group));
        $translation->delete();

        return response()->json(['ok' => true]);
    }

    // ADMIN: clear cache theo tham số
    public function clearCache(Request $r)
    {
        $lo = $r->string('locale')->toString() ?: app()->getLocale();
        $ns = $r->string('namespace')->toString() ?: '*';
        $gr = $r->string('group')->toString() ?: '*';

        Cache::forget($this->key($lo, $ns, $gr));
        return response()->json(['ok' => true, 'message' => "Cleared i18n cache {$lo}/{$ns}/{$gr}"]);
    }
}

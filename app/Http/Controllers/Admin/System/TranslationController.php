<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\TranslationUpsertRequest;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    private function cacheKey(string $locale, string $namespace, string $group): string
    {
        return "i18n:{$locale}:{$namespace}:{$group}";
    }
    private function forgetCache(string $locale, string $namespace, string $group): void
    {
        Cache::forget($this->cacheKey($locale, $namespace, $group));
    }

    public function index(Request $r)
    {
        $q  = $r->string('q')->toString();
        $lo = $r->string('locale')->toString();
        $ns = $r->string('namespace')->toString();
        $gr = $r->string('group')->toString();

        $rows = Translation::when($lo, fn($x) => $x->where('locale', $lo))
            ->when($ns, fn($x) => $x->where('namespace', $ns))
            ->when($gr, fn($x) => $x->where('group', $gr))
            ->when($q, fn($x) => $x->where(function ($w) use ($q) {
                $w->where('key', 'like', "%$q%")->orWhere('value', 'like', "%$q%");
            }))
            ->orderBy('locale')->orderBy('group')->orderBy('key')
            ->paginate(10);

        return view('admin.system.translations.index', compact('rows', 'q', 'lo', 'ns', 'gr'));
    }

    public function create()
    {
        return view('admin.system.translations.form', ['tr' => new Translation()]);
    }
    public function store(TranslationUpsertRequest $r)
    {
        $data = $r->validated();
        $data['updated_by'] = optional($r->user('admin'))->id;
        $row = Translation::create($data);
        $this->forgetCache($row->locale, $row->namespace, $row->group);
        return redirect()->route('admin.translations.index')->with('ok', 'Created');
    }
    public function edit(Translation $translation)
    {
        return view('admin.system.translations.form', ['tr' => $translation]);
    }

    public function update(TranslationUpsertRequest $r, Translation $translation)
    {
        $translation->fill($r->validated());
        $translation->updated_by = optional($r->user('admin'))->id;
        $translation->save();
        $this->forgetCache($translation->locale, $translation->namespace, $translation->group);
        return redirect()->route('admin.translations.index')->with('ok', 'Updated');
    }

    public function destroy(Translation $translation)
    {
        $this->forgetCache($translation->locale, $translation->namespace, $translation->group);
        $translation->delete();
        return back()->with('ok', 'Deleted');
    }

    public function clearCache(Request $r)
    {
        $lo = $r->string('locale')->toString() ?: app()->getLocale();
        $ns = $r->string('namespace')->toString() ?: '*';
        $gr = $r->string('group')->toString() ?: '*';
        $this->forgetCache($lo, $ns, $gr);
        return back()->with('ok', "Cleared cache for {$lo}/{$ns}/{$gr}");
    }
}

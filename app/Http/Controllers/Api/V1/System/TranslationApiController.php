<?php

namespace App\Http\Controllers\Api\V1\System;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TranslationApiController extends Controller
{
    // Gợi ý: bảo vệ bằng sanctum + quyền phù hợp trong routes/api.php
    // Route::middleware('auth:sanctum')->apiResource('translations', ...);

    public function index(Request $request)
    {
        $q = Translation::query();

        if ($locale = $request->string('locale')->trim()->toString()) {
            $q->where('locale', $locale);
        }
        if ($key = $request->string('key')->trim()->toString()) {
            $q->where('key', 'like', "%{$key}%");
        }

        // per_page=0 → trả hết (cẩn thận performance). Mặc định paginate.
        $perPage = max(0, (int)$request->input('per_page', 20));
        if ($perPage === 0) {
            $items = $q->orderBy('locale')->orderBy('key')->get();
            return response()->json(['data' => $items]);
        }

        $page = $q->orderBy('locale')->orderBy('key')->paginate($perPage)
            ->appends($request->query());

        return response()->json([
            'data' => $page->items(),
            'meta' => [
                'current_page' => $page->currentPage(),
                'per_page'     => $page->perPage(),
                'total'        => $page->total(),
                'last_page'    => $page->lastPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'locale' => ['required', 'string', 'max:10'],
            'key'    => ['required', 'string', 'max:190', Rule::unique('translations')->where(fn($q) => $q->where('locale', $request->input('locale')))],
            'value'  => ['nullable', 'string'],
        ]);

        $data['key'] = Str::of($data['key'])->trim();

        $model = Translation::create($data);

        return response()->json(['data' => $model], 201);
    }

    public function show(Translation $translation)
    {
        return response()->json(['data' => $translation]);
    }

    public function update(Request $request, Translation $translation)
    {
        $data = $request->validate([
            'locale' => ['required', 'string', 'max:10'],
            'key'    => [
                'required',
                'string',
                'max:190',
                Rule::unique('translations')->where(fn($q) => $q->where('locale', $request->input('locale')))
                    ->ignore($translation->id),
            ],
            'value'  => ['nullable', 'string'],
        ]);

        $data['key'] = Str::of($data['key'])->trim();

        $translation->update($data);

        return response()->json(['data' => $translation]);
    }

    public function destroy(Translation $translation)
    {
        $translation->delete();
        return response()->json([], 204);
    }
}

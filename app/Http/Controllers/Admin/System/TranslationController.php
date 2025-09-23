<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TranslationController extends Controller
{
    public function __construct()
    {
        // Ví dụ: yêu cầu quyền manage-settings (tùy Policy/Permission của bạn)
        $this->middleware('can:manage-settings');
    }

    public function index(Request $request)
    {
        $q = Translation::query();

        if ($locale = $request->string('locale')->trim()->toString()) {
            $q->where('locale', $locale);
        }
        if ($keyword = $request->string('q')->trim()->toString()) {
            // Tìm theo key hoặc value
            $q->where(function ($qq) use ($keyword) {
                $qq->where('key', 'like', "%{$keyword}%")
                    ->orWhere('value', 'like', "%{$keyword}%");
            });
        }

        $translations = $q->orderBy('locale')->orderBy('key')
            ->paginate($request->integer('per_page', 20))
            ->appends($request->query());

        // Trả về Blade cho admin (không dùng Filament)
        return view('admin.system.translations.index', compact('translations'));
    }

    public function create()
    {
        return view('admin.system.translations.create');
    }

    public function store(Request $request)
    {
        // Nếu bạn đã có FormRequest riêng thì thay validate() bằng request class
        $data = $request->validate([
            'locale' => ['required', 'string', 'max:10'],
            'key'    => ['required', 'string', 'max:190', Rule::unique('translations')->where(fn($q) => $q->where('locale', $request->input('locale')))],
            'value'  => ['nullable', 'string'],
        ]);

        // Chuẩn hóa key (không bắt buộc)
        $data['key'] = Str::of($data['key'])->trim();

        Translation::create($data);

        return redirect()->route('admin.translations.index')->with('ok', true);
    }

    public function edit(Translation $translation)
    {
        return view('admin.system.translations.edit', compact('translation'));
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

        return redirect()->route('admin.translations.index')->with('ok', true);
    }

    public function destroy(Translation $translation)
    {
        $translation->delete();
        return redirect()->route('admin.translations.index')->with('ok', true);
    }
}

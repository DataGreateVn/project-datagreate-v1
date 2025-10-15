@extends('admin.layout')
@section('title', $setting->exists ? 'Edit Setting' : 'Create Setting')

@section('content')
<div class="p-4 sm:p-6">
    {{-- Header --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-4">
        <h1 class="text-lg sm:text-xl font-semibold">
            {{ $setting->exists ? 'Edit Setting' : 'Create Setting' }}
        </h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.settings.index') }}"
                class="h-10 px-3 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 flex items-center">
                ← Back
            </a>
        </div>
    </div>

    {{-- Server errors --}}
    @if ($errors->any())
    <div class="mb-3 rounded border border-red-200 bg-red-50 text-red-700 px-3 py-2 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST"
        action="{{ $setting->exists ? route('admin.settings.update', $setting) : route('admin.settings.store') }}"
        class="bg-white border rounded-lg p-4 sm:p-6 max-w-5xl">
        @csrf
        @if($setting->exists) @method('PUT') @endif

        <div class="grid gap-4 md:grid-cols-2">
            {{-- NAME --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Name (unique)</label>
                <input type="text" name="name"
                    value="{{ old('name', $setting->name) }}"
                    class="w-full h-11 rounded-md border-slate-300 px-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 font-mono text-[13px]"
                    placeholder="site.name"
                    {{ $setting->exists ? 'readonly' : '' }}
                    required>
                @if($setting->exists)
                <p class="mt-1 text-xs text-gray-500">Khoá tên không thể đổi (readonly).</p>
                @else
                <p class="mt-1 text-xs text-gray-500">Gợi ý: dùng dot-notation, ví dụ: <code>mail.host</code>, <code>seo.default_title</code>…</p>
                @endif
            </div>

            {{-- VALUE + Tools --}}
            <div class="md:col-span-2">
                <div class="flex items-center justify-between gap-3 mb-1">
                    <label class="block text-sm font-medium">Value (JSON hoặc text)</label>

                    {{-- JSON toolbar --}}
                    <div class="flex flex-wrap gap-2">
                        <button type="button" data-action="beautify"
                            class="px-2 py-1.5 text-xs rounded border border-slate-300 bg-white hover:bg-slate-50">
                            Beautify
                        </button>
                        <button type="button" data-action="minify"
                            class="px-2 py-1.5 text-xs rounded border border-slate-300 bg-white hover:bg-slate-50">
                            Minify
                        </button>
                        <button type="button" data-action="validate"
                            class="px-2 py-1.5 text-xs rounded border border-slate-300 bg-white hover:bg-slate-50">
                            Validate
                        </button>
                        <button type="button" data-action="copy"
                            class="px-2 py-1.5 text-xs rounded border border-slate-300 bg-white hover:bg-slate-50">
                            Copy
                        </button>
                    </div>
                </div>

                <textarea name="val" id="valInput"
                    class="w-full rounded-md border-slate-300 px-3 py-2 font-mono text-[13px] leading-5 min-h-[220px] focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30"
                    placeholder='Ví dụ JSON: {"title":"Hello","flag":true} || hoặc text: Xin chào'>@php
$raw = old('val', $setting->getRawOriginal('val'));
try {
    $decoded = $raw ? json_decode($raw, true) : null;
    if (json_last_error() === JSON_ERROR_NONE && $decoded !== null && is_array($decoded)) {
        echo json_encode($decoded, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    } elseif (is_string($raw)) {
        echo $raw;
    }
} catch (\Throwable $e) {
    echo $raw;
}
@endphp</textarea>

                {{-- client-side validation state --}}
                <div id="jsonState" class="mt-2 hidden">
                    <div id="jsonOk" class="rounded border border-emerald-200 bg-emerald-50 text-emerald-700 px-3 py-2 text-xs">
                        JSON hợp lệ.
                    </div>
                    <div id="jsonErr" class="rounded border border-red-200 bg-red-50 text-red-700 px-3 py-2 text-xs hidden">
                        JSON không hợp lệ: <span id="jsonErrMsg"></span>
                    </div>
                </div>

                <p class="mt-2 text-xs text-gray-500">
                    • Nếu nhập JSON hợp lệ: sẽ lưu đúng cấu trúc JSON (object/array/number/bool/null).<br>
                    • Nếu nhập text thường: Model sẽ lưu chuỗi đó (string).<br>
                    • Mẹo: dùng Beautify/Minify để định dạng nhanh.
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-5 flex flex-col-reverse sm:flex-row sm:items-center gap-2">
            <a href="{{ route('admin.settings.index') }}"
                class="h-11 px-4 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 flex items-center justify-center">
                Cancel
            </a>
            <button class="h-11 px-5 rounded-md bg-slate-900 text-white hover:brightness-110 flex items-center justify-center">
                {{ $setting->exists ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</div>

{{-- Tiny JS: JSON tools (no deps) --}}
@push('scripts')
<script>
    (function() {
        const ta = document.getElementById('valInput');
        const wrap = document.getElementById('jsonState');
        const okEl = document.getElementById('jsonOk');
        const errEl = document.getElementById('jsonErr');
        const errMsg = document.getElementById('jsonErrMsg');

        function tryParseJSON(s) {
            if (!s || !s.trim()) return {
                ok: false,
                reason: 'Trống'
            };
            try {
                const v = JSON.parse(s);
                return {
                    ok: true,
                    value: v
                };
            } catch (e) {
                return {
                    ok: false,
                    reason: e.message || 'Lỗi không xác định'
                };
            }
        }

        function showOk() {
            wrap.classList.remove('hidden');
            okEl.classList.remove('hidden');
            errEl.classList.add('hidden');
        }

        function showErr(msg) {
            wrap.classList.remove('hidden');
            okEl.classList.add('hidden');
            errEl.classList.remove('hidden');
            errMsg.textContent = msg || '';
        }

        function beautify() {
            const s = ta.value;
            const r = tryParseJSON(s);
            if (!r.ok) {
                showErr(r.reason);
                return;
            }
            ta.value = JSON.stringify(r.value, null, 2);
            showOk();
        }

        function minify() {
            const s = ta.value;
            const r = tryParseJSON(s);
            if (!r.ok) {
                showErr(r.reason);
                return;
            }
            ta.value = JSON.stringify(r.value);
            showOk();
        }

        function validate() {
            const s = ta.value;
            const r = tryParseJSON(s);
            r.ok ? showOk() : showErr(r.reason);
        }

        function copy() {
            const text = ta.value || '';
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.querySelector('[data-action="copy"]');
                const old = btn.textContent;
                btn.textContent = 'Copied!';
                setTimeout(() => btn.textContent = old, 1200);
            }).catch(() => alert('Copy failed'));
        }

        document.addEventListener('click', (e) => {
            const act = e.target?.dataset?.action;
            if (!act) return;
            if (act === 'beautify') beautify();
            if (act === 'minify') minify();
            if (act === 'validate') validate();
            if (act === 'copy') copy();
        });

        // Auto grow (basic)
        function autoGrow() {
            ta.style.height = 'auto';
            ta.style.height = Math.min(Math.max(ta.scrollHeight, 220), 800) + 'px';
        }
        ta.addEventListener('input', autoGrow);
        window.addEventListener('load', autoGrow);
    })();
</script>
@endpush
@endsection
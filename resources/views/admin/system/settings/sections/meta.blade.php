<h2 class="font-semibold mb-4">Meta</h2>

{{-- KHÔNG dùng <form> ở đây. Chỉ là các field nằm trong form cha #settingsForm --}}
<div class="grid gap-4">
    {{-- Default SEO Title --}}
    <div>
        <label for="seo_default_title" class="block text-[13px] font-medium text-slate-700 mb-1">
            Default SEO Title
        </label>
        <input id="seo_default_title" name="settings[seo.default_title]"
            value="{{ old('settings.seo.default_title', setting('seo.default_title')) }}"
            class="w-full h-10 rounded-xl border border-slate-300/80 bg-white px-3 text-[14px]
                      placeholder:text-slate-400
                      focus:outline-none focus:ring-2 focus:ring-[#ff8a00]/40 focus:border-[#ff8a00]" />
        @error('settings.seo.default_title')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Default Meta Description + đếm ký tự --}}
    <div>
        <div class="flex items-center justify-between">
            <label for="seo_default_description" class="block text-[13px] font-medium text-slate-700 mb-1">
                Default Meta Description
            </label>
            <span id="meta-desc-count" class="text-xs text-slate-500">0 / 160</span>
        </div>

        <textarea id="seo_default_description" name="settings[seo.default_description]" rows="3"
            class="w-full rounded-xl border border-slate-300/80 bg-white px-3 py-2 text-[14px]
                         placeholder:text-slate-400
                         focus:outline-none focus:ring-2 focus:ring-[#ff8a00]/40 focus:border-[#ff8a00]">{{ old('settings.seo.default_description', setting('seo.default_description')) }}</textarea>
        @error('settings.seo.default_description')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-[12px] text-slate-500">Khuyến nghị 120–160 ký tự.</p>
    </div>
</div>

{{-- Nút hành động trỏ về form cha --}}
<div class="mt-4 flex items-center gap-3">
    <button type="submit" form="settingsForm" name="__action" value="save"
        class="inline-flex items-center h-10 px-4 rounded-xl bg-[#ff8a00] text-white text-[14px] font-semibold hover:brightness-95">
        Lưu
    </button>
    <button type="submit" form="settingsForm" name="__action" value="clear"
        class="inline-flex items-center h-10 px-4 rounded-xl border border-slate-300/80 bg-white text-slate-700 text-[14px] hover:bg-slate-50">
        Xoá cache
    </button>
</div>

@push('scripts')
<script>
    (function() {
        const el = document.getElementById('seo_default_description');
        const counter = document.getElementById('meta-desc-count');
        if (!el || !counter) return;
        const update = () => counter.textContent = (el.value ?? '').length + ' / 160';
        el.addEventListener('input', update);
        update();
    })();
</script>
@endpush
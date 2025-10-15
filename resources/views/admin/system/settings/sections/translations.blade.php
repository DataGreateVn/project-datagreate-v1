<h2 class="font-semibold mb-4">Translations (i18n)</h2>

<div class="flex items-center gap-2 mb-4">
    <a href="{{ route('admin.translations.index') }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-sm">
        Mở trang quản lý đầy đủ
    </a>
    <form action="{{ route('admin.translations.clear') }}" method="POST" class="inline">@csrf
        <button class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 text-sm">Clear i18n cache</button>
    </form>
</div>

<form action="{{ route('admin.settings.bulk') }}" method="POST" class="grid gap-4 md:grid-cols-2">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">Default locale</label>
        <input name="settings[i18n.default_locale]" value="{{ setting('i18n.default_locale','vi') }}" class="w-full border rounded-lg px-3 py-2" />
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Namespaces được phép</label>
        <input name="settings[i18n.namespaces]" value="{{ implode(',', (array) setting('i18n.namespaces', ['*'])) }}" class="w-full border rounded-lg px-3 py-2" />
        <p class="text-xs text-slate-500 mt-1">VD: *,site,admin</p>
    </div>
    <div class="md:col-span-2">
        <button class="px-4 py-2 rounded-lg bg-amber-600 text-white">Lưu</button>
    </div>
</form>

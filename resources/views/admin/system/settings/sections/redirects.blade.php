<h2 class="font-semibold mb-4">Redirects</h2>
<p class="text-slate-500 text-sm mb-2">
    {{ t('admin.settings.redirects.hint','JSON: [{"from":"/old","to":"/new","code":301}]') }}
</p>
<form action="{{ route('admin.settings.bulk') }}" method="POST" class="space-y-4">
    @csrf
    <textarea name="settings[seo.redirects]" rows="10" class="w-full border rounded-lg px-3 py-2 font-mono">{{ json_encode(setting('seo.redirects') ?? [], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) }}</textarea>
    <button class="px-4 py-2 rounded-lg bg-amber-600 text-white">{{ t('admin.settings.actions.save','Lưu') }}</button>
</form>
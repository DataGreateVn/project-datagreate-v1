<h2 class="font-semibold mb-4">robots.txt</h2>
<form action="{{ route('admin.settings.bulk') }}" method="POST" class="space-y-4">
    @csrf
    <textarea name="settings[seo.robots]" rows="12" class="w-full border rounded-lg px-3 py-2 font-mono">{{ setting('seo.robots') }}</textarea>
    <button class="px-4 py-2 rounded-lg bg-amber-600 text-white">Lưu</button>
</form>

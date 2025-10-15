<form action="{{ route('admin.settings.bulk') }}" method="POST" class="space-y-5">
    @csrf
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium mb-1">Tên Doanh Nghiệp</label>
            <input name="settings[site.company_name]" value="{{ old('settings.site.company_name', setting('site.company_name')) }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Tên Website</label>
            <input name="settings[site.name]" value="{{ setting('site.name') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email Liên Hệ</label>
            <input name="settings[site.email]" value="{{ setting('site.email') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input name="settings[site.phone]" value="{{ setting('site.phone') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div class="md:col-span-2 border-t pt-4"></div>

        <div>
            <label class="block text-sm font-medium mb-1">Fb Link</label>
            <input name="settings[social.facebook]" value="{{ setting('social.facebook') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Fb Message Link</label>
            <input name="settings[social.fb_message]" value="{{ setting('social.fb_message') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Instagram Link</label>
            <input name="settings[social.instagram]" value="{{ setting('social.instagram') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Youtube Link</label>
            <input name="settings[social.youtube]" value="{{ setting('social.youtube') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">LinkedIn Link</label>
            <input name="settings[social.linkedin]" value="{{ setting('social.linkedin') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Zalo Link</label>
            <input name="settings[social.zalo]" value="{{ setting('social.zalo') }}"
                class="w-full border rounded-lg px-3 py-2" />
        </div>
    </div>

    <div class="pt-2">
        <button class="px-4 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">Lưu</button>
        <form action="{{ route('admin.settings.clear') }}" method="POST" class="inline">@csrf
            <button class="ml-2 px-3 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200">Xoá cache</button>
        </form>
    </div>
</form>

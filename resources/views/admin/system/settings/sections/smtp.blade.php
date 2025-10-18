<h2 class="font-semibold mb-4">
    {{ t('admin.settings.smtp.title','Cấu hình SMTP') }}
</h2>

<form action="{{ route('admin.settings.bulk') }}" method="POST" class="grid gap-4 md:grid-cols-2">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">MAIL_MAILER</label>
        <input name="settings[mail.mailer]"
            value="{{ old('settings.mail.mailer', setting('mail.mailer') ?? 'smtp') }}"
            class="w-full border rounded-lg px-3 py-2" placeholder="smtp" />
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">MAIL_HOST</label>
        <input name="settings[mail.host]" value="{{ old('settings.mail.host', setting('mail.host')) }}"
            class="w-full border rounded-lg px-3 py-2" placeholder="smtp.yourhost.com" />
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">MAIL_PORT</label>
        <input name="settings[mail.port]" value="{{ old('settings.mail.port', setting('mail.port') ?? 587) }}"
            class="w-full border rounded-lg px-3 py-2" inputmode="numeric" placeholder="587" />
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">MAIL_USERNAME</label>
        <input name="settings[mail.username]" value="{{ old('settings.mail.username', setting('mail.username')) }}"
            class="w-full border rounded-lg px-3 py-2" placeholder="no-reply@yourdomain.com" />
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">MAIL_PASSWORD</label>
        <input type="password" name="settings[mail.password]" value=""
            class="w-full border rounded-lg px-3 py-2" placeholder="••••••••" />
        <p class="text-xs text-slate-500 mt-1">
            {{ t('admin.settings.smtp.hint_password','Để trống để giữ mật khẩu hiện tại.') }}
        </p>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">MAIL_ENCRYPTION</label>
        <input name="settings[mail.encryption]"
            value="{{ old('settings.mail.encryption', setting('mail.encryption') ?? 'tls') }}"
            class="w-full border rounded-lg px-3 py-2" placeholder="tls hoặc ssl" />
    </div>

    <div class="md:col-span-2">
        <button class="px-4 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">
            {{ t('admin.settings.actions.save','Lưu') }}
        </button>
    </div>
</form>
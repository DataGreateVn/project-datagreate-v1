<!doctype html>
<html lang="{{ str_replace('_','-', app_locale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ t('admin.auth_login.page_title','Data Greate Admin — Đăng nhập') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --brand: #ff8a00;
            --brand-100: #fff1df;
            --brand-200: #ffe1bf;
            --brand-300: #ffd29f;
            --brand-500: #ff8a00;
            --brand-600: #ef7f00;
        }

        body {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        }

        .glass-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 6px 24px rgba(15, 23, 42, .06);
            border-radius: 1rem;
        }

        .logo-bright {
            filter: brightness(1.15) contrast(1.1);
            transition: filter .3s;
        }

        .logo-bright:hover {
            filter: brightness(1.25) contrast(1.2);
        }

        .input-brand:focus {
            outline: none;
            border-color: var(--brand-500) !important;
            box-shadow: 0 0 0 3px rgba(255, 138, 0, .15);
        }

        .checkbox-brand {
            accent-color: var(--brand-500);
        }

        .btn-brand {
            background-image: linear-gradient(90deg, var(--brand-500), #ffb84d);
        }

        .btn-brand:hover {
            background-image: linear-gradient(90deg, var(--brand-600), #ffab26);
            filter: brightness(0.98);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center relative text-gray-700">

    {{-- Dropdown lá cờ phía trên góc phải --}}
    @php
    $current = app_locale();
    $current = in_array($current, ['vi','en']) ? $current : 'vi';
    $langLabel = $current === 'en'
    ? t('admin.layout.lang_english','English')
    : t('admin.layout.lang_vietnamese','Tiếng Việt');
    $flagPath = $current === 'en' ? 'images/flags/en.svg' : 'images/flags/vi.svg';
    $langUrl = fn($code) => url()->current() . '?' . http_build_query(array_merge(request()->except('page','lang'), ['lang' => $code]));
    @endphp

    <div x-data="{ open:false }" class="absolute top-4 right-4">
        <button
            @click="open=!open"
            @keydown.escape.window="open=false"
            class="flex items-center gap-2 px-3 py-1.5 rounded-md border border-[#ff8a00] text-[#ff8a00] font-medium text-sm bg-white hover:bg-orange-50 transition focus:outline-none focus:ring-2 focus:ring-[#ff8a00]/50">
            <img src="{{ asset($flagPath) }}" class="w-5 h-5" alt="flag">
            <span>{{ $langLabel }}</span>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 ml-1 transition-transform duration-150"
                :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6" />
            </svg>
        </button>

        <div x-cloak x-show="open" x-transition
            @click.outside="open=false"
            class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-lg shadow-lg py-1 border border-[#ff8a00]/40 z-50 overflow-hidden">
            <a href="{{ $langUrl('vi') }}" role="menuitem"
                class="flex items-center gap-2 px-3 py-2 text-[13px] hover:bg-orange-50 {{ $current==='vi' ? 'bg-[#fff7eb] border-l-2 border-[#ff8a00]' : '' }}">
                <img src="{{ asset('images/flags/vi.svg') }}" class="w-5 h-5" alt="Tiếng Việt">
                <span>Tiếng Việt</span>
            </a>
            <a href="{{ $langUrl('en') }}" role="menuitem"
                class="flex items-center gap-2 px-3 py-2 text-[13px] hover:bg-orange-50 {{ $current==='en' ? 'bg-[#fff7eb] border-l-2 border-[#ff8a00]' : '' }}">
                <img src="{{ asset('images/flags/en.svg') }}" class="w-5 h-5" alt="English">
                <span>English</span>
            </a>
        </div>
    </div>

    {{-- Thẻ card login --}}
    <div class="w-full max-w-sm p-8 glass-card mt-12">

        {{-- Logo --}}
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('storage/logo-datagreate.png') }}" alt="Data Greate Logo" class="w-48 h-auto logo-bright mb-3">
            <h1 class="text-lg font-semibold text-slate-800 tracking-wide">
                {{ t('admin.auth_login.heading','Admin Portal') }}
            </h1>
            <p class="text-sm text-slate-500">
                {{ t('admin.auth_login.subheading','Đăng nhập để quản lý hệ thống') }}
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf

            @if ($errors->any())
            <div class="text-[#b45309] text-sm bg-amber-50 border border-amber-200 rounded-lg p-2">
                {{ t('admin.auth_login.error_first', $errors->first()) }}
            </div>
            @endif

            <div>
                <label class="block text-sm mb-1 text-slate-700 font-medium">
                    {{ t('admin.auth_login.email_label','Email') }}
                </label>
                <input type="email" name="email" required
                    placeholder="{{ t('admin.auth_login.email_placeholder','admin@datagreate.vn') }}"
                    class="w-full rounded-lg px-3 py-2 border border-slate-300 input-brand text-slate-800 placeholder-slate-400" />
            </div>

            <div>
                <label class="block text-sm mb-1 text-slate-700 font-medium">
                    {{ t('admin.auth_login.password_label','Mật khẩu') }}
                </label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        placeholder="{{ t('admin.auth_login.password_placeholder','••••••••') }}"
                        class="w-full rounded-lg px-3 py-2 pr-10 border border-slate-300 input-brand text-slate-800 placeholder-slate-400" />
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600"
                        aria-label="Toggle password">
                        <svg xmlns="http://www.w3.org/2000/svg" id="eye-icon" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <label class="flex items-center text-sm text-slate-600">
                <input type="checkbox" name="remember" class="mr-2 rounded border-slate-400 checkbox-brand">
                {{ t('admin.auth_login.remember','Nhớ đăng nhập') }}
            </label>

            <button class="w-full rounded-lg py-2.5 font-semibold text-white shadow-md transition-all duration-200 btn-brand">
                {{ t('admin.auth_login.submit','Đăng nhập') }}
            </button>
        </form>

        <div class="text-center mt-6 text-xs text-slate-500">
            {!! str_replace(':year', e(date('Y')), e(t('admin.auth_login.footer','© :year Data Greate VN — Admin System'))) !!}
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
             d="M3.98 8.223A10.477 10.477 0 0 0 2.25 12S6 18.75 12 18.75c1.905 0 3.68-.453 5.22-1.243M9.88 9.88A3 3 0 1 0 14.12 14.12M6.18 6.18 3 3m18 18-3.18-3.18"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
             d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
             d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            }
        }
    </script>
</body>

</html>
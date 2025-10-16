<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title','Admin')</title>

    {{-- Tailwind + Alpine --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --brand: #ff8a00;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar mảnh cho sidebar */
        .thin-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px
        }

        .thin-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(120, 120, 120, .6);
            border-radius: 6px
        }

        .thin-scrollbar::-webkit-scrollbar-track {
            background: transparent
        }

        /* Vạch cam bên trái khi active */
        .nav-item.active {
            position: relative;
        }

        .nav-item.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            background: #ff8a00;
            border-radius: 2px;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <a href="#main"
        class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] bg-white rounded px-3 py-2 shadow">
        Bỏ qua nội dung điều hướng
    </a>

    @php
    // ======= Brand + Flag helpers =======
    use App\Models\Setting;

    $brandName = Setting::getVal('site_name', 'Data Greate VN');
    $brandParts = preg_split('/\s+/', $brandName, 2);
    $logoPath = Setting::getVal('site_logo', '');
    $brandInitial = mb_strtoupper(mb_substr($brandName, 0, 1, 'UTF-8'));
    $logoExists = $logoPath && file_exists(public_path($logoPath));

    $current = app()->getLocale();
    $current = in_array($current, ['vi','en']) ? $current : 'vi';
    $langLabel = $current === 'en' ? 'English' : 'Tiếng Việt';
    $flagPath = $current === 'en' ? 'images/flags/en.svg' : 'images/flags/vi.svg';

    // Giữ nguyên query hiện tại (trừ page/lang), thêm lang=code
    $langUrl = fn($code) => url()->current() . '?' . http_build_query(array_merge(request()->except('page','lang'), ['lang' => $code]));
    @endphp

    <div class="min-h-screen flex">
        <!-- Toggle mobile -->
        <input id="nav-open" type="checkbox" class="peer sr-only" />

        {{-- ========== SIDEBAR ========== --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 w-72 max-w-[80vw] bg-[#0f0f0f] text-white flex flex-col
                   -translate-x-full peer-checked:translate-x-0 transition-transform duration-200
                   md:static md:translate-x-0 md:w-64">

            {{-- Brand --}}
            <div class="px-4 pt-5 pb-3 border-b border-white/10 shrink-0">
                <div class="flex items-center gap-3">
                    @if ($logoExists)
                    <img src="{{ asset($logoPath) }}" class="h-10 w-auto" alt="logo">
                    @else
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#ff8a00] text-black text-lg font-bold shadow-md">
                        {{ $brandInitial }}
                    </div>
                    @endif
                    <div class="font-semibold leading-tight">
                        <div class="truncate">{{ $brandParts[0] ?? $brandName }}</div>
                        <div class="truncate">{{ $brandParts[1] ?? '' }}</div>
                    </div>
                </div>
            </div>

            {{-- Menu --}}
            @php
            function mActive($pattern) {
            return request()->routeIs($pattern)
            ? 'nav-item active bg-[#ff8a00]/20 text-[#ff8a00]'
            : 'text-white/80 hover:text-white hover:bg-white/10';
            }
            function ariaActive($pattern) {
            return request()->routeIs($pattern) ? 'aria-current=page' : '';
            }
            @endphp

            <nav class="flex-1 overflow-y-auto thin-scrollbar px-2 py-3 space-y-1 text-[15px]">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded outline-none focus:ring-2 focus:ring-[#ff8a00] {{ mActive('admin.dashboard') }}"
                    {{ ariaActive('admin.dashboard') }}>
                    <x-heroicon-o-home class="w-5 h-5" />
                    <span class="truncate">Dashboard</span>
                </a>

                <div class="border-t border-white/10 my-2"></div>

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded outline-none focus:ring-2 focus:ring-[#ff8a00] {{ mActive('admin.settings.*') }}"
                    {{ ariaActive('admin.settings.*') }}>
                    <x-heroicon-o-wrench-screwdriver class="w-5 h-5" />
                    <span class="truncate">Settings</span>
                </a>

                <a href="{{ route('admin.translations.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded outline-none focus:ring-2 focus:ring-[#ff8a00] {{ mActive('admin.translations.*') }}"
                    {{ ariaActive('admin.translations.*') }}>
                    <x-heroicon-o-document-text class="w-5 h-5" />
                    <span class="truncate">Translations</span>
                </a>
            </nav>

            {{-- Footer cố định + logout --}}
            <div class="shrink-0 border-t border-white/10 bg-black/80">
                <div class="flex items-center justify-between px-4 py-3 text-white/90">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-[#f4a90a] text-black text-sm font-bold shadow-md">
                            A
                        </span>
                        <div class="text-[15px] leading-tight min-w-0">
                            <div class="text-white font-semibold truncate">Admin</div>
                            <a href="#"
                                class="text-sm text-[#ffb000] hover:text-[#ffd67a] hover:underline font-medium transition">
                                Đổi mật khẩu
                            </a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button
                            class="p-2.5 rounded-lg hover:bg-white/10 text-white outline-none focus:ring-2 focus:ring-[#ff8a00] transition"
                            title="Đăng xuất">
                            <x-heroicon-o-arrow-right-start-on-rectangle class="w-6 h-6" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Backdrop mobile --}}
        <label for="nav-open"
            class="fixed inset-0 z-30 bg-black/40 opacity-0 pointer-events-none transition
                      md:hidden peer-checked:opacity-100 peer-checked:pointer-events-auto"></label>

        {{-- ========== MAIN ========== --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Topbar --}}
            <header class="h-14 bg-white border-b sticky top-0 z-20">
                <div class="h-full w-full px-3 sm:px-5 flex items-center justify-between gap-3">

                    {{-- Left: breadcrumb + toggle --}}
                    <div class="flex items-center gap-2 min-w-0">
                        <label for="nav-open"
                            class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer outline-none focus:ring-2 focus:ring-sky-500"
                            aria-label="Mở menu" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                        <div class="min-w-0 flex-1">
                            <x-admin::breadcrumb :items="$breadcrumbs ?? \App\Support\Breadcrumbs::make()" />
                        </div>
                    </div>

                    {{-- Right: Language dropdown (flag + text + caret) --}}
                    <div x-data="{ open:false }" class="relative">
                        <button
                            @click="open = !open"
                            @keydown.escape.window="open=false"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-md border border-[#ff8a00] text-[#ff8a00] font-medium text-sm bg-white hover:bg-orange-50 transition focus:outline-none focus:ring-2 focus:ring-[#ff8a00]/50"
                            aria-haspopup="menu"
                            :aria-expanded="open">
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
                            class="absolute right-0 mt-2 w-44 bg-white text-gray-800 rounded-lg shadow-lg py-1 border border-[#ff8a00]/40 z-50 overflow-hidden"
                            role="menu" aria-label="Language menu">
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
                </div>
            </header>

            {{-- Content --}}
            <main id="main" class="py-4 sm:py-6">
                <div class="px-3 sm:px-5">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>
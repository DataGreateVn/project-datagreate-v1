<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title','Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen flex">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white border-r hidden md:flex md:flex-col">
            <div class="h-14 flex items-center px-4 border-b">
                <div class="flex items-center gap-2 font-semibold">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                    <span>Admin</span>
                </div>
            </div>

            <nav class="p-3 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 font-medium' : '' }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                        <path d="M3 12l9-8 9 8v8a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-8z" stroke="currentColor" stroke-width="1.5" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-100 font-medium' : '' }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3l1.5 2.6 3-.2-.9 2.9 2.3 2-2.3 2 .9 2.9-3-.2L12 21l-1.5-2.6-3 .2.9-2.9-2.3-2 2.3-2-.9-2.9 3 .2L12 3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                    Settings
                </a>

                {{-- Thêm các mục khác nếu cần --}}
            </nav>

            <div class="mt-auto p-3 border-t">
                <form action="{{ route('admin.logout') }}" method="POST">@csrf
                    <button class="w-full px-3 py-2 text-left text-red-600 hover:bg-red-50 rounded-lg">Đăng xuất</button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">
            {{-- TOP BAR --}}
            <header class="h-14 bg-white border-b">
                <div class="h-full max-w-7xl mx-auto px-4 flex items-center justify-between">
                    <div class="text-sm text-slate-500">
                        @yield('breadcrumb')
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ url()->current() }}" method="GET" class="hidden sm:flex items-center">
                            <input name="global_q" value="{{ request('global_q') }}"
                                class="h-9 w-64 rounded-lg border-slate-200 focus:ring-2 focus:ring-sky-500 focus:outline-none text-sm px-3"
                                placeholder="Search...">
                        </form>
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-slate-200 inline-block"></span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>

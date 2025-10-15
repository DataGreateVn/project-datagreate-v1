<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Data Greate Admin — Đăng nhập</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        }

        /* Card trắng sáng có viền và bóng nhẹ */
        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
            border-radius: 1rem;
        }

        .logo-bright {
            filter: brightness(1.15) contrast(1.1);
            transition: filter 0.3s ease;
        }

        .logo-bright:hover {
            filter: brightness(1.25) contrast(1.2);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-gray-700">

    <div class="w-full max-w-sm p-8 glass-card">
        {{-- Logo --}}
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('storage/logo-datagreate.png') }}" alt="Data Greate Logo"
                class="w-48 h-auto logo-bright mb-3">
            <h1 class="text-lg font-semibold text-slate-800 tracking-wide">Admin Portal</h1>
            <p class="text-sm text-slate-500">Đăng nhập để quản lý hệ thống</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf

            @if ($errors->any())
            <div class="text-red-600 text-sm bg-red-50 border border-red-200 rounded-lg p-2">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Email --}}
            <div>
                <label class="block text-sm mb-1 text-slate-700 font-medium">Email</label>
                <input type="email" name="email" placeholder="admin@datagreate.vn" required
                    class="w-full rounded-lg px-3 py-2 border border-slate-300 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 outline-none text-slate-800 placeholder-slate-400" />
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm mb-1 text-slate-700 font-medium">Mật khẩu</label>
                <div class="relative">
                    <input id="password" type="password" name="password" placeholder="••••••••" required
                        class="w-full rounded-lg px-3 py-2 pr-10 border border-slate-300 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 outline-none text-slate-800 placeholder-slate-400" />
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600">
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

            {{-- Remember --}}
            <label class="flex items-center text-sm text-slate-600">
                <input type="checkbox" name="remember"
                    class="mr-2 rounded border-slate-400 text-sky-500 focus:ring-sky-400">
                Nhớ đăng nhập
            </label>

            {{-- Submit --}}
            <button
                class="w-full rounded-lg py-2.5 font-semibold text-white shadow-md transition-all duration-200
               bg-gradient-to-r from-sky-500 to-cyan-400 hover:from-sky-400 hover:to-cyan-300">
                Đăng nhập
            </button>
        </form>

        <div class="text-center mt-6 text-xs text-slate-500">
            © {{ date('Y') }} <span class="font-semibold text-sky-600">Data Greate VN</span> — Admin System
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M3.98 8.223A10.477 10.477 0 0 0 2.25 12S6 18.75 12 18.75c1.905 0 3.68-.453 5.22-1.243M9.88 9.88A3 3 0 1 0 14.12 14.12M6.18 6.18 3 3m18 18-3.18-3.18"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            }
        }
    </script>
</body>

</html>
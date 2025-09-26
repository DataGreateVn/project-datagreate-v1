<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-6 rounded shadow w-full max-w-sm">
        @csrf
        <h1 class="text-xl font-semibold mb-4">Đăng nhập Admin</h1>
        @if ($errors->any())
        <div class="mb-3 text-red-600 text-sm">{{ $errors->first() }}</div>
        @endif
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" class="w-full border rounded px-3 py-2 mb-3" required />
        <label class="block text-sm mb-1">Mật khẩu</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2 mb-3" required />
        <label class="inline-flex items-center mb-3">
            <input type="checkbox" name="remember" class="mr-2"> Nhớ đăng nhập
        </label>
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Đăng nhập</button>
    </form>
</body>

</html>
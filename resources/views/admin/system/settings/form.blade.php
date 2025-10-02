@extends('admin.layout')
@section('title', $setting->exists ? 'Edit Setting' : 'Create Setting')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">
            {{ $setting->exists ? 'Edit Setting' : 'Create Setting' }}
        </h1>
        <a href="{{ route('admin.settings.index') }}" class="px-3 py-1 bg-gray-200 rounded">← Back</a>
    </div>

    @if ($errors->any())
    <div class="mb-3 text-red-600 text-sm">{{ $errors->first() }}</div>
    @endif

    <form method="POST"
        action="{{ $setting->exists ? route('admin.settings.update', $setting) : route('admin.settings.store') }}"
        class="space-y-4 bg-white border rounded p-4 max-w-3xl">
        @csrf
        @if($setting->exists) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name (unique)</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $setting->name) }}"
                class="w-full border rounded px-3 py-2 font-mono"
                placeholder="site_name"
                {{ $setting->exists ? 'readonly' : '' }}
                required>
            @if($setting->exists)
            <p class="mt-1 text-xs text-gray-500">Khoá tên không thể đổi (đang readonly).</p>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Value (JSON hoặc text)</label>
            <textarea name="val"
                class="w-full border rounded px-3 py-2 font-mono"
                rows="8"
                placeholder='Ví dụ JSON: {"title":"Hello","flag":true} || hoặc text thường: "Xin chào"'>@php
    // Hiển thị đẹp: nếu là mảng/object -> pretty JSON, nếu là string -> in chuỗi
    $raw = old('val', $setting->getRawOriginal('val'));
    try {
        $decoded = $raw ? json_decode($raw, true) : null;
        if (json_last_error() === JSON_ERROR_NONE && $decoded !== null && is_array($decoded)) {
            echo json_encode($decoded, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        } elseif (is_string($raw)) {
            echo $raw;
        }
    } catch (\Throwable $e) {
        echo $raw;
    }
@endphp</textarea>
            <p class="mt-1 text-xs text-gray-500">
                - Nếu bạn nhập JSON hợp lệ: sẽ lưu đúng JSON. <br>
                - Nếu nhập text thường: Model sẽ tự bọc thành JSON string.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button class="px-4 py-2 rounded bg-slate-900 text-white">
                {{ $setting->exists ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded bg-gray-200">Cancel</a>
        </div>
    </form>
</div>
@endsection
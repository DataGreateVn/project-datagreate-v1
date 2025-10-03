@extends('admin.layout')
@section('title', $tr->exists ? 'Edit Translation' : 'Create Translation')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">
            {{ $tr->exists ? 'Edit Translation' : 'Create Translation' }}
        </h1>
        <a href="{{ route('admin.translations.index') }}" class="px-3 py-1 bg-gray-200 rounded">← Back</a>
    </div>

    @if ($errors->any())
    <div class="mb-3 text-red-600 text-sm">{{ $errors->first() }}</div>
    @endif

    <form method="POST"
        action="{{ $tr->exists ? route('admin.translations.update', $tr) : route('admin.translations.store') }}"
        class="space-y-4 bg-white border rounded p-4 max-w-3xl">
        @csrf
        @if($tr->exists) @method('PUT') @endif

        <div class="grid md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Locale</label>
                <input type="text" name="locale" value="{{ old('locale', $tr->locale ?? 'vi') }}"
                    class="w-full border rounded px-3 py-2" placeholder="vi" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Namespace</label>
                <input type="text" name="namespace" value="{{ old('namespace', $tr->namespace ?? '*') }}"
                    class="w-full border rounded px-3 py-2" placeholder="*">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Group</label>
                <input type="text" name="group" value="{{ old('group', $tr->group ?? 'homepage') }}"
                    class="w-full border rounded px-3 py-2" placeholder="homepage" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Key</label>
            <input type="text" name="key" value="{{ old('key', $tr->key) }}"
                class="w-full border rounded px-3 py-2 font-mono" placeholder="hero.title" required {{ $tr->exists ? '' : '' }}>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Value</label>
            <textarea name="value" rows="6" class="w-full border rounded px-3 py-2"
                placeholder="Tiêu đề anh hùng">{{ old('value', $tr->value) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Hỗ trợ text dài, có thể dán JSON nhưng sẽ lưu dạng chuỗi.</p>
        </div>

        <div class="flex items-center gap-2">
            <button class="px-4 py-2 rounded bg-slate-900 text-white">
                {{ $tr->exists ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('admin.translations.index') }}" class="px-3 py-2 rounded bg-gray-200">Cancel</a>
        </div>
    </form>
</div>
@endsection
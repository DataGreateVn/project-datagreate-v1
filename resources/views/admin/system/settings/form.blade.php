@extends('admin.layout')
@section('title', $setting->exists ? 'Edit Setting' : 'New Setting')
@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-xl font-semibold mb-4">{{ $setting->exists ? 'Edit' : 'Create' }} Setting</h1>
    <form method="POST" action="{{ $setting->exists ? route('admin.settings.update',$setting) : route('admin.settings.store') }}">
        @csrf
        @if($setting->exists) @method('PUT') @endif

        <label class="block text-sm mb-1">Name</label>
        <input name="name" value="{{ old('name', $setting->name) }}" class="w-full border rounded px-3 py-2 mb-3" required>

        <label class="block text-sm mb-1">Value (text hoặc JSON)</label>
        <textarea name="val" rows="6" class="w-full border rounded px-3 py-2 mb-3">{{ old('val', is_array($setting->val)? json_encode($setting->val, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : $setting->val) }}</textarea>

        @if ($errors->any())
        <div class="mb-3 text-red-600 text-sm">{{ $errors->first() }}</div>
        @endif

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">{{ $setting->exists ? 'Update' : 'Create' }}</button>
            <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection
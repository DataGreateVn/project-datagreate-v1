@extends('admin.layout')
@section('title','Translations')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Translations</h1>
        <div class="space-x-2">
            <form action="{{ route('admin.translations.index') }}" method="GET" class="inline-flex gap-2 items-center">
                <input type="text" name="q" value="{{ $q }}" class="border px-2 py-1 rounded" placeholder="Search key/value...">
                <input type="text" name="locale" value="{{ $locale }}" class="border px-2 py-1 rounded w-24" placeholder="vi">
                <input type="text" name="namespace" value="{{ $namespace }}" class="border px-2 py-1 rounded w-28" placeholder="*">
                <input type="text" name="group" value="{{ $group }}" class="border px-2 py-1 rounded w-32" placeholder="homepage">
                <button class="px-3 py-1 bg-gray-200 rounded">Search</button>
            </form>
            <a href="{{ route('admin.translations.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">+ New</a>

            <form action="{{ route('admin.translations.clear') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="locale" value="{{ $locale }}">
                <input type="hidden" name="namespace" value="{{ $namespace }}">
                <input type="hidden" name="group" value="{{ $group }}">
                <button class="px-3 py-1 bg-amber-500 text-white rounded" title="Clear cache theo bộ lọc hiện tại">Clear Cache</button>
            </form>
        </div>
    </div>

    @if (session('ok')) <div class="mb-3 text-green-700">{{ session('ok') }}</div> @endif

    <table class="w-full border bg-white">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Locale</th>
                <th class="p-2 text-left">Namespace</th>
                <th class="p-2 text-left">Group</th>
                <th class="p-2 text-left">Key</th>
                <th class="p-2 text-left">Value</th>
                <th class="p-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
            <tr class="border-t">
                <td class="p-2 text-sm">{{ $r->locale }}</td>
                <td class="p-2 text-sm">{{ $r->namespace }}</td>
                <td class="p-2 text-sm">{{ $r->group }}</td>
                <td class="p-2 font-mono text-sm">{{ $r->key }}</td>
                <td class="p-2 text-sm whitespace-pre-wrap">{{ $r->value }}</td>
                <td class="p-2 text-right space-x-2">
                    <a href="{{ route('admin.translations.edit', $r) }}" class="px-2 py-1 bg-gray-200 rounded">Edit</a>
                    <form action="{{ route('admin.translations.destroy', $r) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="px-2 py-1 bg-red-600 text-white rounded" onclick="return confirm('Delete?')">Del</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td class="p-4" colspan="6">No data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">{{ $rows->withQueryString()->links() }}</div>
</div>
@endsection
@extends('admin.layout')
@section('title','Settings')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Settings</h1>
        <div class="space-x-2">
            <form action="{{ route('admin.settings.index') }}" method="GET" class="inline">
                <input type="text" name="q" value="{{ $q }}" class="border px-2 py-1 rounded" placeholder="Search name...">
                <button class="px-3 py-1 bg-gray-200 rounded">Search</button>
            </form>
            <a href="{{ route('admin.settings.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">+ New</a>
            <form action="{{ route('admin.settings.clear') }}" method="POST" class="inline">@csrf
                <button class="px-3 py-1 bg-amber-500 text-white rounded">Clear Cache</button>
            </form>
        </div>
    </div>
    @if (session('ok')) <div class="mb-3 text-green-700">{{ session('ok') }}</div> @endif
    <table class="w-full border bg-white">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Value</th>
                <th class="p-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($settings as $s)
            <tr class="border-t">
                <td class="p-2 font-mono text-sm">{{ $s->name }}</td>
                <td class="p-2 text-sm whitespace-pre-wrap">{{ is_array($s->val) ? json_encode($s->val, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : $s->val }}</td>
                <td class="p-2 text-right space-x-2">
                    <a href="{{ route('admin.settings.edit', $s) }}" class="px-2 py-1 bg-gray-200 rounded">Edit</a>
                    <form action="{{ route('admin.settings.destroy',$s) }}" method="POST" class="inline">@csrf @method('DELETE')
                        <button class="px-2 py-1 bg-red-600 text-white rounded" onclick="return confirm('Delete?')">Del</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td class="p-4" colspan="3">No data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">{{ $settings->withQueryString()->links() }}</div>
</div>
@endsection
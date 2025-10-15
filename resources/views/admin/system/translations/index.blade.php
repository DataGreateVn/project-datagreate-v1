@extends('admin.layout')
@section('title','Translations')

@push('styles')
<style>
    .thin-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px
    }

    .thin-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(120, 120, 120, .4);
        border-radius: 6px
    }

    .thin-scrollbar::-webkit-scrollbar-track {
        background: transparent
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6 space-y-4">

    {{-- TOP BAR --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-xl font-semibold">Translation Management</h1>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.translations.index') }}" method="GET" class="relative w-[260px]">
                <input type="text" name="q" value="{{ $q }}"
                    class="w-full h-9 rounded-md border border-slate-300 pl-9 pr-3 text-[13px] placeholder:text-slate-400
                           focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]"
                    placeholder="Tìm kiếm...">
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m1.1-5.4A7.75 7.75 0 1110.75 3a7.75 7.75 0 017.75 7.75z" />
                </svg>
            </form>

            <a href="{{ route('admin.translations.create') }}"
                class="inline-flex items-center h-9 px-3 rounded-md bg-[#ff8a00] text-white text-[13px] font-semibold hover:brightness-95">
                <span class="text-lg leading-none mr-1">＋</span> Thêm mới
            </a>
        </div>
    </div>

    {{-- Thông báo --}}
    @if (session('ok'))
    <div class="rounded border border-emerald-200 bg-emerald-50 text-emerald-700 px-3 py-1.5 text-sm">
        {{ session('ok') }}
    </div>
    @endif

    {{-- TABLE --}}
    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white border rounded-md">
        <table class="min-w-full text-[13px]">
            <thead class="bg-slate-100 text-slate-600 sticky top-0 z-10">
                <tr class="uppercase text-[11px] tracking-wide">
                    <th class="px-4 py-2 text-left w-[90px]">Locale</th>
                    <th class="px-4 py-2 text-left w-[160px]">Namespace</th>
                    <th class="px-4 py-2 text-left w-[160px]">Group</th>
                    <th class="px-4 py-2 text-left min-w-[260px]">Key</th>
                    <th class="px-4 py-2 text-left min-w-[340px]">Value</th>
                    <th class="px-4 py-2 text-right w-[140px]">Actions</th>
                </tr>
            </thead>

            <tbody class="[&_tr:nth-child(odd)]:bg-slate-50/40">
                @forelse($rows as $r)
                @php
                $val = (string) $r->value;
                $short = \Illuminate\Support\Str::limit(preg_replace('/\s+/',' ', $val), 120);
                $locale = $r->locale ?: '{var}';
                $ns = $r->namespace ?: '{var}';
                $group = $r->group ?: '{var}';
                $key = $r->key ?: '{var}';
                @endphp

                <tr class="border-t hover:bg-slate-50 transition-colors">
                    {{-- LOCALE --}}
                    <td class="px-4 py-2 text-slate-800">{{ $locale }}</td>

                    {{-- NAMESPACE (tím nhẹ) --}}
                    <td class="px-4 py-2">
                        <span class="text-violet-600">{{ $ns }}</span>
                    </td>

                    {{-- GROUP (tím nhẹ) --}}
                    <td class="px-4 py-2">
                        <span class="text-violet-600">{{ $group }}</span>
                    </td>

                    {{-- KEY (mono, xanh đậm hơn) --}}
                    <td class="px-4 py-2">
                        <span class="font-mono text-[12px] text-sky-700 break-words">{{ $key }}</span>
                    </td>

                    {{-- VALUE (ô input + nút Copy giống ảnh) --}}
                    <td class="px-4 py-2">
                        <div class="flex items-center gap-2">
                            <input
                                type="text"
                                value="{{ $short }}"
                                readonly
                                class="h-8 w-full max-w-[520px] rounded-md border border-slate-300 px-3 text-[12px]
                                       bg-white focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]" />
                            <button type="button"
                                onclick="navigator.clipboard.writeText(@js($val)); this.textContent='Copied!'; setTimeout(()=>this.textContent='Copy',1000)"
                                class="shrink-0 h-8 px-3 rounded-md border border-slate-300 bg-white text-[12px] hover:bg-slate-50">
                                Copy
                            </button>
                        </div>
                    </td>

                    {{-- ACTIONS (Edit/Del gọn về phải) --}}
                    <td class="px-4 py-2">
                        <div class="flex justify-end gap-1.5">
                            <a href="{{ route('admin.translations.edit', $r) }}"
                                class="px-2.5 h-8 inline-flex items-center rounded-md border border-slate-300 bg-white text-slate-700 text-[12px] hover:bg-slate-50">
                                Edit
                            </a>
                            <form action="{{ route('admin.translations.destroy', $r) }}" method="POST"
                                onsubmit="return confirm('Delete?')" class="inline">
                                @csrf @method('DELETE')
                                <button
                                    class="px-2.5 h-8 inline-flex items-center rounded-md bg-red-600 text-white text-[12px] hover:brightness-95">
                                    Del
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-slate-500 text-sm">
                        Không có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION (pills cam như ảnh) --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t bg-white gap-2 text-[12.5px] text-slate-600">
            <div class="flex flex-wrap items-center gap-1">
                @if ($rows->hasPages())
                @php
                $linkLimit = 5;
                $half = floor($linkLimit/2);
                $start = max($rows->currentPage() - $half, 1);
                $end = min($start + $linkLimit - 1, $rows->lastPage());
                @endphp

                {{-- Prev --}}
                @if ($rows->onFirstPage())
                <span class="px-2.5 py-1 rounded-md border border-slate-300 bg-slate-100 text-slate-400">‹</span>
                @else
                <a href="{{ $rows->previousPageUrl() }}"
                    class="px-2.5 py-1 rounded-md border border-[#ff8a00]/40 text-[#ff8a00] hover:bg-[#ff8a00] hover:text-white">‹</a>
                @endif

                {{-- Numbers --}}
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i==$rows->currentPage())
                    <span class="px-2.5 py-1 rounded-md border border-[#ff8a00] bg-[#ff8a00] text-white font-semibold">{{ $i }}</span>
                    @else
                    <a href="{{ $rows->url($i) }}"
                        class="px-2.5 py-1 rounded-md border border-[#ff8a00]/40 text-[#ff8a00] hover:bg-[#ff8a00] hover:text-white">{{ $i }}</a>
                    @endif
                    @endfor

                    {{-- Next --}}
                    @if ($rows->hasMorePages())
                    <a href="{{ $rows->nextPageUrl() }}"
                        class="px-2.5 py-1 rounded-md border border-[#ff8a00]/40 text-[#ff8a00] hover:bg-[#ff8a00] hover:text-white">›</a>
                    @else
                    <span class="px-2.5 py-1 rounded-md border border-slate-300 bg-slate-100 text-slate-400">›</span>
                    @endif
                    @endif
            </div>

            <div>
                Từ {{ $rows->firstItem() ?? 0 }} đến {{ $rows->lastItem() ?? 0 }} trên {{ $rows->total() }}
            </div>
        </div>
    </div>

</div>
@endsection

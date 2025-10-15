@extends('admin.layout')
@section('title','Settings')

@section('content')
<div class="p-4 sm:p-6">
    {{-- Header + Actions --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
        <h1 class="text-lg sm:text-xl font-semibold">Settings</h1>

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
            {{-- Search + per_page --}}
            <form action="{{ route('admin.settings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="flex gap-2">
                    <input type="text" name="q" value="{{ $q }}"
                        class="w-full sm:w-64 h-10 rounded-md border-slate-300 px-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30"
                        placeholder="Search name...">
                    <select name="per_page"
                        class="h-10 rounded-md border-slate-300 px-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30">
                        @foreach([10,20,50,100] as $n)
                        <option value="{{ $n }}" @selected((int)request('per_page',20)===$n)>{{ $n }}/page</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button class="h-10 px-3 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50">
                        Search
                    </button>
                    <a href="{{ route('admin.settings.index') }}"
                        class="h-10 px-3 rounded-md border border-slate-200 bg-white text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Actions --}}
            <div class="flex gap-2">
                <a href="{{ route('admin.settings.create') }}"
                    class="inline-flex items-center justify-center h-10 px-3 sm:px-4 rounded-md bg-blue-600 text-white hover:brightness-95">
                    + New
                </a>
                <form action="{{ route('admin.settings.clear') }}" method="POST" class="inline">@csrf
                    <button class="inline-flex items-center justify-center h-10 px-3 sm:px-4 rounded-md bg-amber-500 text-white hover:brightness-95">
                        Clear Cache
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if (session('ok'))
    <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-700 px-3 py-2">
        {{ session('ok') }}
    </div>
    @endif

    {{-- ========== MOBILE: card list (md:hidden) ========== --}}
    <div class="space-y-3 md:hidden">
        @forelse($settings as $s)
        <div class="bg-white border rounded-lg p-3">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="font-mono text-[13px] font-semibold truncate" title="{{ $s->name }}">{{ $s->name }}</div>
                    <div class="mt-1">
                        {{-- Collapsible value --}}
                        @php
                        $isArray = is_array($s->val);
                        $strVal = $isArray ? json_encode($s->val, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : (string) $s->val;
                        $short = str($strVal)->limit(260);
                        $isLong = mb_strlen($strVal) > mb_strlen($short);
                        @endphp

                        <pre class="text-xs text-slate-700 whitespace-pre-wrap break-words max-h-48 overflow-auto thin-scrollbar js-value" data-full="{{ e($strVal) }}">{{ $isLong ? $short : $strVal }}</pre>

                        <div class="mt-2 flex items-center gap-2">
                            @if($isLong)
                            <button type="button" class="text-xs px-2 py-1 rounded border border-slate-300 bg-white hover:bg-slate-50 js-toggle">
                                Show more
                            </button>
                            @endif
                            <button type="button" class="text-xs px-2 py-1 rounded border border-slate-300 bg-white hover:bg-slate-50 js-copy">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>

                <div class="shrink-0 flex flex-col items-end gap-2">
                    <a href="{{ route('admin.settings.edit', $s) }}"
                        class="px-2 py-1 rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 text-sm">Edit</a>
                    <form action="{{ route('admin.settings.destroy', $s) }}" method="POST" onsubmit="return confirm('Delete?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="px-2 py-1 rounded bg-red-600 text-white text-sm">Del</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-4 bg-white border rounded">No data</div>
        @endforelse

        <div class="mt-3">{{ $settings->withQueryString()->links() }}</div>
    </div>

    {{-- ========== DESKTOP/TABLET: table (hidden below md) ========== --}}
    <div class="hidden md:block">
        <div class="overflow-x-auto bg-white border rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 sticky top-0">
                    <tr class="text-slate-700">
                        <th class="p-2 text-left w-[320px]">Name</th>
                        <th class="p-2 text-left">Value</th>
                        <th class="p-2 w-[160px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $s)
                    <tr class="border-t align-top hover:bg-slate-50/50">
                        <td class="p-2 font-mono text-[13px] md:text-sm break-words">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-6 min-w-6 items-center justify-center rounded bg-slate-100 text-slate-600 text-xs">{{ $s->id }}</span>
                                <span class="break-words">{{ $s->name }}</span>
                            </div>
                        </td>
                        <td class="p-2">
                            @php
                            $isArray = is_array($s->val);
                            $strVal = $isArray ? json_encode($s->val, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : (string) $s->val;
                            $short = str($strVal)->limit(600);
                            $isLong = mb_strlen($strVal) > mb_strlen($short);
                            @endphp

                            <pre class="whitespace-pre-wrap break-words max-h-72 overflow-auto thin-scrollbar text-[13px] md:text-sm js-value" data-full="{{ e($strVal) }}">{{ $isLong ? $short : $strVal }}</pre>

                            <div class="mt-2 flex items-center gap-2">
                                @if($isLong)
                                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-300 bg-white hover:bg-slate-50 js-toggle">
                                    Show more
                                </button>
                                @endif
                                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-300 bg-white hover:bg-slate-50 js-copy">
                                    Copy
                                </button>
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.settings.edit', $s) }}"
                                    class="px-2 py-1 rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-50">Edit</a>
                                <form action="{{ route('admin.settings.destroy', $s) }}" method="POST" onsubmit="return confirm('Delete?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-red-600 text-white">Del</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="p-4" colspan="3">No data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $settings->withQueryString()->links() }}</div>
    </div>
</div>

{{-- Tiny helpers: toggle & copy --}}
@push('scripts')
<script>
    document.addEventListener('click', function(e) {
        // Toggle long text
        if (e.target.classList.contains('js-toggle')) {
            const pre = e.target.closest('div').previousElementSibling; // <pre>
            if (!pre) return;
            const full = pre.dataset.full || '';
            const showingFull = pre.dataset.showing === '1';
            if (showingFull) {
                // Collapse back (simple heuristic: cut to 600 chars for desktop, 260 for mobile)
                const isMobile = window.matchMedia('(max-width: 767px)').matches;
                const limit = isMobile ? 260 : 600;
                pre.textContent = full.slice(0, limit) + (full.length > limit ? '…' : '');
                pre.dataset.showing = '0';
                e.target.textContent = 'Show more';
            } else {
                pre.textContent = full;
                pre.dataset.showing = '1';
                e.target.textContent = 'Show less';
            }
        }

        // Copy to clipboard
        if (e.target.classList.contains('js-copy')) {
            const pre = e.target.closest('div').previousElementSibling; // <pre>
            if (!pre) return;
            const text = pre.dataset.full || pre.textContent || '';
            navigator.clipboard.writeText(text).then(() => {
                const old = e.target.textContent;
                e.target.textContent = 'Copied!';
                setTimeout(() => e.target.textContent = old, 1200);
            }).catch(() => {
                alert('Copy failed');
            });
        }
    });
</script>
@endpush
@endsection
@php
use Illuminate\Support\Str;

// Chuẩn hoá các field hiển thị (fallback {var} để không trống)
$locale = $r->locale ?: '{var}';
$ns = $r->namespace ?: '{var}';
$group = $r->group ?: '{var}';
$key = $r->key ?: '{var}';

$val = (string) $r->value;
$short = Str::limit(preg_replace('/\s+/', ' ', $val), 120);
@endphp

<tr class="border-t hover:bg-slate-50 transition-colors">
    {{-- Locale --}}
    <td class="px-4 py-2 text-slate-800 w-[90px]">{{ $locale }}</td>

    {{-- Namespace --}}
    <td class="px-4 py-2 w-[160px]">
        <span class="text-violet-600">{{ $ns }}</span>
    </td>

    {{-- Group --}}
    <td class="px-4 py-2 w-[160px]">
        <span class="text-violet-600">{{ $group }}</span>
    </td>

    {{-- Key --}}
    <td class="px-4 py-2 min-w-[260px]">
        <span class="font-mono text-[12px] text-sky-700 break-words">{{ $key }}</span>
    </td>

    {{-- Value + Copy --}}
    <td class="px-4 py-2 min-w-[340px]">
        <div class="flex items-center gap-2">
            <input
                type="text"
                value="{{ $short }}"
                readonly
                class="h-8 w-full max-w-[520px] rounded-md border border-slate-300 px-3 text-[12px]
                       bg-white focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]" />
            <button type="button"
                onclick="navigator.clipboard.writeText(@js($val)); this.textContent='Copied!'; setTimeout(()=>this.textContent='Copy',900)"
                class="shrink-0 h-8 px-3 rounded-md border border-slate-300 bg-white text-[12px] hover:bg-slate-50">
                Copy
            </button>
        </div>
    </td>

    {{-- Actions --}}
    <td class="px-4 py-2 w-[140px]">
        <div class="flex justify-end gap-1.5">
            <a href="{{ route('admin.translations.edit', $r) }}"
                class="px-2.5 h-8 inline-flex items-center rounded-md border border-slate-300 bg-white text-slate-700 text-[12px] hover:bg-slate-50">
                Edit
            </a>
            <form action="{{ route('admin.translations.destroy', $r) }}" method="POST"
                onsubmit="return confirm('Delete?')" class="inline">
                @csrf
                @method('DELETE')
                <button
                    class="px-2.5 h-8 inline-flex items-center rounded-md bg-red-600 text-white text-[12px] hover:brightness-95">
                    Del
                </button>
            </form>
        </div>
    </td>
</tr>
@php
use Illuminate\Support\Str;

/** @var \App\Models\Translation $r */
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
        <div x-data="{ label: @js(t('admin.translations.row.copy','Copy')) }" class="flex items-center gap-2">
            <input type="text" value="{{ $short }}" readonly
                class="h-8 w-full max-w-[520px] rounded-md border border-slate-300 px-3 text-[12px]
                   bg-white focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]" />
            <button type="button"
                @click="
                    navigator.clipboard.writeText(@js($val));
                    label = @js(t('admin.translations.row.copied','Copied!'));
                    setTimeout(() => label = @js(t('admin.translations.row.copy','Copy')), 900);
                "
                class="shrink-0 h-8 px-3 rounded-md border border-slate-300 bg-white text-[12px] hover:bg-slate-50"
                x-text="label">
            </button>
        </div>
    </td>

    {{-- Actions --}}
    <td class="px-4 py-2 w-[120px]">
        <div class="flex justify-end gap-1.5">
            {{-- Edit --}}
            <a href="{{ route('admin.translations.edit', $r) }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-100"
                title="{{ t('admin.translations.row.edit','Edit') }}">
                {{-- Heroicon: pencil --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l2.651 2.651m-2.651-2.651a2.121 2.121 0 013 3L7.5 21H4v-3.5l12.862-12.863z" />
                </svg>
            </a>

            {{-- Delete --}}
            <form x-data
                @submit.prevent='if (confirm(@json(t("admin.translations.row.confirm_delete","Delete?")))) $el.submit()'
                action="{{ route('admin.translations.destroy', $r) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-600 text-white hover:brightness-95"
                    title="{{ t('admin.translations.row.delete','Delete') }}">
                    {{-- Heroicon: trash --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 7h12m-1 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V7m3-3h4a1 1 0 011 1v1H8V5a1 1 0 011-1z" />
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>
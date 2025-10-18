@props([
/**
* $columns: Mảng cột, ví dụ:
* [
* ['key'=>'locale', 'label'=>'Locale', 'class'=>'w-[90px] text-left'],
* ['key'=>'namespace', 'label'=>'Namespace', 'class'=>'w-[160px] text-left'],
* ]
*/
'columns' => [],

/** $rows: Collection hoặc LengthAwarePaginator */
'rows' => [],

/** View path để render từng hàng tuỳ biến (vd: 'admin.system.translations.row') */
'rowView' => null,

/** Text khi rỗng */
'empty' => null,

/** Bật/ tắt zebra row */
'striped' => true,

/** Sticky header */
'stickyHeader' => true,

/** Số trang hiển thị (window) trong pagination đơn giản */
'pageWindow' => 5,
])

@php
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/* ====== I18N defaults (dùng t() có fallback) ====== */
$emptyText = $empty ?? t('admin.shared.table.empty', 'Không có dữ liệu');
$ariaPrev = t('admin.shared.table.prev', 'Trang trước');
$ariaNext = t('admin.shared.table.next', 'Trang sau');
$sumFmt = t('admin.shared.table.summary', 'Từ :from đến :to trên :total');

/* ====== Chuẩn hoá $columns ====== */
$columns = collect($columns)->map(function($col, $i){
if (is_string($col)) $col = ['key'=>$col, 'label'=>$col];
$col['label'] = $col['label'] ?? ($col['key'] ?? "col_$i");
$col['class'] = $col['class'] ?? 'text-left';
return $col;
})->all();

$isPaginator = $rows instanceof LengthAwarePaginator;

/* ====== Pagination window ====== */
$currentPage = $isPaginator ? $rows->currentPage() : 1;
$lastPage = $isPaginator ? $rows->lastPage() : 1;
$half = (int) floor($pageWindow / 2);
$start = max($currentPage - $half, 1);
$end = min($start + $pageWindow - 1, $lastPage);
if ($end - $start + 1 < $pageWindow) {
    $start=max($end - $pageWindow + 1, 1);
    }
    @endphp

    <div {{ $attributes->merge(['class' => 'overflow-x-auto bg-white border rounded-md']) }}>
    <table class="min-w-full text-[13px]">
        <thead class="{{ $stickyHeader ? 'sticky top-0 z-10' : '' }} bg-slate-100 text-slate-600">
            <tr class="uppercase text-[11px] tracking-wide">
                @foreach ($columns as $col)
                <th class="px-4 py-2 {{ $col['class'] }}">{{ $col['label'] }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody class="{{ $striped ? '[&_tr:nth-child(odd)]:bg-slate-50/40' : '' }}">
            @forelse ($rows as $r)
            @if ($rowView)
            @include($rowView, ['r' => $r, 'columns' => $columns])
            @else
            <tr class="border-t hover:bg-slate-50 transition-colors">
                @foreach ($columns as $col)
                @php $k = $col['key']; @endphp
                <td class="px-4 py-2 text-slate-800">
                    {{ is_array($r) ? ($r[$k] ?? '') : ($r->{$k} ?? '') }}
                </td>
                @endforeach
            </tr>
            @endif
            @empty
            <tr>
                <td colspan="{{ count($columns) }}" class="px-4 py-10 text-center text-slate-500 text-sm">
                    {{ $emptyText }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if ($isPaginator && $rows->hasPages())
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t bg-white gap-2 text-[12.5px] text-slate-600">
        <div class="flex flex-wrap items-center gap-1">
            {{-- Prev --}}
            @if ($rows->onFirstPage())
            <span class="px-2.5 py-1 rounded-md border border-slate-300 bg-slate-100 text-slate-400" aria-disabled="true" aria-label="{{ $ariaPrev }}">‹</span>
            @else
            <a href="{{ $rows->previousPageUrl() }}"
                class="px-2.5 py-1 rounded-md border border-[#ff8a00]/40 text-[#ff8a00] hover:bg-[#ff8a00] hover:text-white"
                aria-label="{{ $ariaPrev }}">‹</a>
            @endif

            {{-- Numbers --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i==$currentPage)
                <span class="px-2.5 py-1 rounded-md border border-[#ff8a00] bg-[#ff8a00] text-white font-semibold" aria-current="page">{{ $i }}</span>
                @else
                <a href="{{ $rows->url($i) }}"
                    class="px-2.5 py-1 rounded-md border border-[#ff8a00]/40 text-[#ff8a00] hover:bg-[#ff8a00] hover:text-white"
                    aria-label="{{ t('admin.shared.table.goto_page', 'Tới trang :n', ['n'=>$i]) }}">{{ $i }}</a>
                @endif
                @endfor

                {{-- Next --}}
                @if ($rows->hasMorePages())
                <a href="{{ $rows->nextPageUrl() }}"
                    class="px-2.5 py-1 rounded-md border border-[#ff8a00]/40 text-[#ff8a00] hover:bg-[#ff8a00] hover:text-white"
                    aria-label="{{ $ariaNext }}">›</a>
                @else
                <span class="px-2.5 py-1 rounded-md border border-slate-300 bg-slate-100 text-slate-400" aria-disabled="true" aria-label="{{ $ariaNext }}">›</span>
                @endif
        </div>

        <div>
            @php
            $from = $rows->firstItem() ?? 0;
            $to = $rows->lastItem() ?? 0;
            $total = $rows->total();
            $summary = strtr($sumFmt, [':from'=>$from, ':to'=>$to, ':total'=>$total]);
            @endphp
            {{ $summary }}
        </div>
    </div>
    @endif
    </div>
@extends('admin.layout')

@section('title', t('admin.settings.page_title', 'Cấu hình'))
@section('page_title', t('admin.settings.page_heading', 'General'))

@section('content')
@php
// Đọc cấu hình nhóm + map quyền
$cfg = config('admin_settings_groups'); // ĐÚNG tên file config của bạn
$permMap = $cfg['permissions_map'] ?? ['*' => 'manage-settings', 'translations' => 'manage-translations'];
$groups = $groups ?? ($cfg['groups'] ?? []);
$current = $current ?? request()->route('section');

// Hàm lấy quyền theo slug (ưu tiên slug, fallback '*')
$needPerm = function (string $slug) use ($permMap): string {
return $permMap[$slug] ?? ($permMap['*'] ?? 'manage-settings');
};

// Lọc item theo quyền user: chỉ giữ item user có thể truy cập
$visibleGroups = collect($groups)->map(function ($g) use ($needPerm) {
$g['items'] = collect($g['items'] ?? [])->filter(function ($it) use ($needPerm) {
return auth('admin')->user()?->can($needPerm($it['slug'])) ?? false;
})->values()->all();
return $g;
})->filter(function ($g) {
return !empty($g['items']);
})->values();

// Nếu section hiện tại user KHÔNG có quyền, đưa về section đầu tiên mà user có quyền (nếu có)
if ($current) {
$ok = false;
foreach ($visibleGroups as $g) {
foreach ($g['items'] as $it) {
if ($it['slug'] === $current) { $ok = true; break 2; }
}
}
if (!$ok && isset($visibleGroups[0]['items'][0])) {
// redirect nhẹ nhàng bằng meta nếu muốn; ở đây chỉ set lại $current để highlight
$current = $visibleGroups[0]['items'][0]['slug'];
}
} else {
if (isset($visibleGroups[0]['items'][0])) {
$current = $visibleGroups[0]['items'][0]['slug'];
}
}

// Helper CSS active
$itemClass = function (string $slug) use ($current) {
return $slug === $current
? 'nav-item active bg-amber-50 text-amber-700 font-semibold'
: 'text-slate-600 hover:bg-slate-100';
};
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
    {{-- Sidebar trái --}}
    <aside class="lg:col-span-3">
        <div class="bg-white border rounded-xl p-2">
            @forelse($visibleGroups as $g)
            <details class="group" open>
                <summary class="cursor-pointer select-none flex items-center justify-between px-3 py-2 font-medium text-slate-700 hover:bg-slate-50 rounded">
                    {{-- Nhãn nhóm (ưu tiên key dịch) --}}
                    <span>{{ t($g['label_key'] ?? ('admin.settings.group.'.($g['label'] ?? '')), $g['label'] ?? '') }}</span>
                    <svg class="w-4 h-4 transition group-open:rotate-90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 6l6 4-6 4V6z" clip-rule="evenodd" />
                    </svg>
                </summary>
                <nav class="mt-1 pb-2">
                    @foreach($g['items'] as $it)
                    @php
                    $href = route('admin.settings.section', $it['slug']);
                    // label_key ưu tiên; fallback theo convention admin.settings.sidebar.<slug>
                        $itemLabel = t($it['label_key'] ?? ('admin.settings.sidebar.'.$it['slug']), $it['label'] ?? $it['slug']);
                        @endphp
                        <a href="{{ $href }}"
                            class="block relative mx-2 my-1 rounded-lg px-3 py-2 text-sm {{ $itemClass($it['slug']) }}">
                            {{ $itemLabel }}
                        </a>
                        @endforeach
                </nav>
            </details>
            @empty
            <div class="px-3 py-2 text-sm text-slate-500">Bạn không có quyền xem mục Cấu hình nào.</div>
            @endforelse
        </div>
    </aside>

    {{-- Nội dung --}}
    <section class="lg:col-span-9">
        <div class="bg-white border rounded-xl p-4 sm:p-6">
            @if (session('ok'))
            <div class="mb-4 rounded-lg bg-emerald-50 text-emerald-700 px-3 py-2">{{ session('ok') }}</div>
            @endif

            {{-- Nếu partial hiện tại không hợp lệ theo quyền → hiển thị nhắc --}}
            @php
            $canViewCurrent = true;
            if ($current) {
            $required = $needPerm($current);
            $canViewCurrent = auth('admin')->user()?->can($required);
            }
            @endphp

            @if(!$canViewCurrent)
            <div class="text-slate-600">
                {{ __('Bạn không có quyền truy cập phần này.') }}
            </div>
            @else
            @include($partial)
            @endif
        </div>
    </section>
</div>
@endsection
@extends('admin.layout')
@section('title','Cấu hình')
@section('page_title','General')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
    {{-- Sidebar trái --}}
    <aside class="lg:col-span-3">
        <div class="bg-white border rounded-xl p-2">
            @foreach($groups as $g)
            <details class="group" open>
                <summary class="cursor-pointer select-none flex items-center justify-between px-3 py-2 font-medium text-slate-700 hover:bg-slate-50 rounded">
                    <span>{{ $g['label'] }}</span>
                    <svg class="w-4 h-4 transition group-open:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 6l6 4-6 4V6z" clip-rule="evenodd" />
                    </svg>
                </summary>
                <nav class="mt-1 pb-2">
                    @foreach($g['items'] as $it)
                    @php
                    $active = $current === $it['slug'];
                    $href = route('admin.settings.section', $it['slug']);
                    @endphp
                    <a href="{{ $href }}"
                        class="nav-item block relative mx-2 my-1 rounded-lg px-3 py-2 text-sm
                                      {{ $active ? 'active bg-amber-50 text-amber-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ $it['label'] }}
                    </a>
                    @endforeach
                </nav>
            </details>
            @endforeach
        </div>
    </aside>

    {{-- Nội dung --}}
    <section class="lg:col-span-9">
        <div class="bg-white border rounded-xl p-4 sm:p-6">
            @if (session('ok'))
            <div class="mb-4 rounded-lg bg-emerald-50 text-emerald-700 px-3 py-2">{{ session('ok') }}</div>
            @endif
            @include($partial)
        </div>
    </section>
</div>
@endsection

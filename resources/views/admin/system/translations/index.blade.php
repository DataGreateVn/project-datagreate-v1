@extends('admin.layout')
@section('title', t('admin.translations.index.title','Translations'))

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
        <h1 class="text-xl font-semibold">
            {{ t('admin.translations.index.heading','Translation Management') }}
        </h1>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.translations.index') }}" method="GET" class="relative w-[260px]">
                <input type="text" name="q" value="{{ $q }}"
                    class="w-full h-9 rounded-md border border-slate-300 pl-9 pr-3 text-[13px] placeholder:text-slate-400
                           focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]"
                    placeholder="{{ t('admin.translations.index.search_placeholder','Tìm kiếm...') }}">
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m1.1-5.4A7.75 7.75 0 1110.75 3a7.75 7.75 0 017.75 7.75z" />
                </svg>
            </form>

            <a href="{{ route('admin.translations.create') }}"
                class="inline-flex items-center h-9 px-3 rounded-md bg-[#ff8a00] text-white text-[13px] font-semibold hover:brightness-95">
                <span class="text-lg leading-none mr-1">＋</span>
                {{ t('admin.translations.index.add_new','Thêm mới') }}
            </a>
        </div>
    </div>

    {{-- Thông báo --}}
    @if (session('ok'))
    <div class="rounded border border-emerald-200 bg-emerald-50 text-emerald-700 px-3 py-1.5 text-sm">
        {{ session('ok') }}
    </div>
    @endif

    {{-- DATA TABLE --}}
    <x-ui.datatable
        :rows="$rows"
        :columns="[
            ['key'=>'locale',    'label'=> t('admin.translations.index.col_locale','Locale'),     'class'=>'text-left w-[90px]'],
            ['key'=>'namespace', 'label'=> t('admin.translations.index.col_namespace','Namespace'),'class'=>'text-left w-[160px]'],
            ['key'=>'group',     'label'=> t('admin.translations.index.col_group','Group'),       'class'=>'text-left w-[160px]'],
            ['key'=>'key',       'label'=> t('admin.translations.index.col_key','Key'),           'class'=>'text-left min-w-[260px]'],
            ['key'=>'value',     'label'=> t('admin.translations.index.col_value','Value'),       'class'=>'text-left min-w-[340px]'],
            ['key'=>'_actions',  'label'=> t('admin.translations.index.col_actions','Actions'),   'class'=>'text-right w-[160px]'],
        ]"
        rowView="admin.system.translations.row"
        class="thin-scrollbar" />
</div>
@endsection
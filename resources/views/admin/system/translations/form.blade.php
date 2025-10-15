@extends('admin.layout')
@section('title', $tr->exists ? 'Edit Translation' : 'Create Translation')

@push('styles')
<style>
    /* Scrollbar mảnh cho textarea */
    .thin-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px
    }

    .thin-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(120, 120, 120, .45);
        border-radius: 6px
    }

    .thin-scrollbar::-webkit-scrollbar-track {
        background: transparent
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6">

    {{-- TITLE --}}
    <div class="mb-4">
        <div class="mt-3 flex items-center gap-2">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#fff3e6] text-[#ff8a00]">
                <!-- plus icon -->
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                </svg>
            </span>
            <h1 class="text-xl sm:text-2xl font-semibold">
                {{ $tr->exists ? 'Edit Translation' : 'Create Translation' }}
            </h1>
        </div>
        <p class="text-sm text-slate-500 mt-1">
            Quản lý cặp khóa/bản dịch đa ngôn ngữ. Giữ naming nhất quán theo dot-notation.
        </p>
    </div>

    {{-- Alerts --}}
    @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-700 text-sm">
        {{ $errors->first() ?: 'Vui lòng kiểm tra các trường bên dưới.' }}
    </div>
    @endif
    @if (session('ok'))
    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-emerald-700 text-sm">
        {{ session('ok') }}
    </div>
    @endif

    <form method="POST"
        action="{{ $tr->exists ? route('admin.translations.update', $tr) : route('admin.translations.store') }}"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @if ($tr->exists) @method('PUT') @endif

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Card: Thông tin + Value --}}
            <section class="bg-white border border-slate-200 rounded-xl shadow-sm">
                <header class="px-5 py-3 border-b border-slate-200">
                    <h2 class="font-semibold">Thông tin</h2>
                </header>

                <div class="p-5 space-y-5">

                    {{-- Row: Locale / Namespace / Group --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        {{-- Locale --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Locale <span class="text-red-500">*</span>
                            </label>
                            <input name="locale" value="{{ old('locale', $tr->locale ?? 'vi') }}"
                                class="w-full h-10 rounded-md border border-slate-300 px-3 text-sm placeholder:text-slate-400
                           focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]"
                                placeholder="vi" required>
                            @error('locale')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Namespace --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Namespace</label>
                            <input name="namespace" value="{{ old('namespace', $tr->namespace ?? '*') }}"
                                class="w-full h-10 rounded-md border border-slate-300 px-3 text-sm placeholder:text-slate-400
                           focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]"
                                placeholder="*">
                            <p class="text-xs text-slate-500 mt-1">Để <code>*</code> nếu không dùng.</p>
                            @error('namespace')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Group --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Group <span class="text-red-500">*</span>
                            </label>
                            <input name="group" value="{{ old('group', $tr->group ?? 'homepage') }}"
                                class="w-full h-10 rounded-md border border-slate-300 px-3 text-sm placeholder:text-slate-400
                           focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]"
                                placeholder="homepage" required>
                            @error('group')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Key --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Key <span class="text-red-500">*</span>
                        </label>
                        <input name="key" value="{{ old('key', $tr->key) }}"
                            class="w-full h-10 rounded-md border border-slate-300 px-3 text-sm font-mono placeholder:text-slate-400
                       focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]"
                            placeholder="welcome.title" required>
                        <p class="text-xs text-slate-500 mt-1">
                            Dot-notation. Ví dụ: <code>hero.title</code>, <code>buttons.save</code>.
                        </p>
                        @error('key')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Value (nằm chung card) --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Value</label>
                        <textarea name="value" rows="10"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm font-mono thin-scrollbar
                       focus:outline-none focus:ring-1 focus:ring-[#ff8a00]/50 focus:border-[#ff8a00]
                       resize-y min-h-[180px] max-h-[60vh]"
                            placeholder='Plain text hoặc JSON (sẽ được lưu dạng chuỗi)'>{{ old('value', $tr->value) }}</textarea>
                        @error('value')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

                        <div class="flex items-start gap-2 text-xs text-red-600 mt-1">
                            <svg class="w-4 h-4 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                    d="M12 9v4m0 4h.01M12 3a9 9 0 110 18 9 9 0 010-18z" />
                            </svg>
                            Có thể dán JSON; hệ thống sẽ lưu là chuỗi (string).
                        </div>
                    </div>
                </div>
            </section>


            @if($tr->exists && $tr->updated_by)
            <div class="text-xs text-slate-500">
                Cập nhật bởi ID: <span class="font-medium text-slate-700">{{ $tr->updated_by }}</span>
            </div>
            @endif
        </div>

        {{-- RIGHT --}}
        <aside class="lg:col-span-1">
            <div class="lg:sticky lg:top-20 space-y-4">

                {{-- small section label --}}
                <div class="text-[13px] text-slate-500">Actions Section</div>

                {{-- Action card (desktop) --}}
                <section class="hidden md:block bg-white border border-slate-200 rounded-xl p-4">
                    <div class="space-y-2">
                        {{-- Primary: cam + chữ trắng (giống ảnh) --}}
                        <button type="submit"
                            class="w-full h-10 rounded-md bg-[#ff8a00] text-white font-medium
                                       hover:brightness-95 transition focus:ring-2 focus:ring-[#ff8a00]/30">
                            {{ $tr->exists ? 'Save changes' : 'Create' }}
                        </button>

                        {{-- Secondary: Save & New chỉ khi tạo mới (nền trắng, viền xám) --}}
                        @unless($tr->exists)
                        <button type="submit" name="save_and_new" value="1"
                            class="w-full h-10 rounded-md border border-slate-300 bg-white text-slate-700
                                           hover:bg-slate-50 transition">
                            Save & New
                        </button>
                        @endunless

                        {{-- Tertiary: Cancel --}}
                        <a href="{{ route('admin.translations.index') }}"
                            class="block text-center w-full h-10 leading-10 rounded-md border border-slate-300
                                  bg-white text-slate-700 hover:bg-slate-50 transition">
                            Cancel
                        </a>
                    </div>
                </section>

                {{-- Tips --}}
                <section class="bg-white border border-slate-200 rounded-xl p-4">
                    <h3 class="font-medium mb-2">Gợi ý</h3>
                    <ul class="text-sm text-slate-600 list-disc pl-5 space-y-1">
                        <li><code>locale</code>: ví dụ <code>vi</code>, <code>en</code></li>
                        <li><code>namespace</code>: dùng <code>*</code> nếu không dùng</li>
                        <li><code>group</code>: ví dụ <code>homepage</code></li>
                        <li><code>key</code>: ví dụ <code>welcome.title</code></li>
                    </ul>
                </section>
            </div>
        </aside>

        {{-- Action bar sticky (mobile / tablet) --}}
        <div class="md:hidden fixed inset-x-0 bottom-0 z-20 bg-white/95 backdrop-blur border-t p-3">
            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('admin.translations.index') }}"
                    class="inline-flex items-center justify-center h-10 px-3 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
                <button
                    class="inline-flex items-center justify-center h-10 px-4 rounded-md bg-[#ff8a00] text-white font-medium hover:brightness-95 focus:ring-2 focus:ring-[#ff8a00]/30">
                    {{ $tr->exists ? 'Save changes' : 'Create' }}
                </button>
            </div>
        </div>
        <div class="h-14 md:h-0"></div>
    </form>
</div>
@endsection
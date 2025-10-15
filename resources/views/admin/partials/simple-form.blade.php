{{-- Simple Admin Form (no component), Tailwind CDN ok --}}
@php
/** @var string $title */
/** @var string $action */
/** @var string $backUrl */
/** @var string $method */ // GET|POST|PUT|PATCH|DELETE (default POST)
/** @var string $submitText */ // default: Save
/** @var array $fields */ // each: ['name','label','type','value','placeholder','required','readonly','rows','options'=>[],'help']
$method = $method ?? 'POST';
$submitText = $submitText ?? 'Save';
$backUrl = $backUrl ?? url()->previous();
$gridCols = $gridCols ?? 'md:grid-cols-2'; // đổi nếu muốn 1/3 cột
@endphp

<div class="p-4 sm:p-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-4">
        <h1 class="text-lg sm:text-xl font-semibold">{{ $title ?? 'Form' }}</h1>
        <a href="{{ $backUrl }}"
            class="h-10 px-3 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 flex items-center">
            ← Back
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-3 rounded border border-red-200 bg-red-50 text-red-700 px-3 py-2 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ $action }}" class="bg-white border rounded-lg p-4 sm:p-6 max-w-5xl">
        @csrf
        @if(in_array(strtoupper($method), ['PUT','PATCH','DELETE']))
        @method($method)
        @endif

        <div class="grid gap-4 {{ $gridCols }}">
            @foreach($fields as $f)
            @php
            $type = $f['type'] ?? 'text';
            $name = $f['name'] ?? '';
            $label = $f['label'] ?? ucfirst($name);
            $value = old($name, $f['value'] ?? '');
            $placeholder = $f['placeholder'] ?? '';
            $required = !empty($f['required']);
            $readonly = !empty($f['readonly']);
            $rows = $f['rows'] ?? 6;
            $help = $f['help'] ?? null;
            $options = $f['options'] ?? []; // for select
            $checked = (bool)($f['checked'] ?? false);
            $colSpan = $f['col'] ?? 'md:col-span-1'; // e.g., md:col-span-2
            @endphp

            @if($type === 'hidden')
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @continue
            @endif

            <div class="{{ $colSpan }}">
                <label class="block text-sm font-medium mb-1" for="f-{{ $name }}">{{ $label }} @if($required)<span class="text-red-500">*</span>@endif</label>

                @switch($type)
                @case('textarea')
                <textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
                    class="w-full rounded-md border-slate-300 px-3 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30"
                    placeholder="{{ $placeholder }}"
                    @if($readonly) readonly @endif
                    @if($required) required @endif>{{ $value }}</textarea>
                @break

                @case('select')
                <select id="f-{{ $name }}" name="{{ $name }}"
                    class="w-full h-11 rounded-md border-slate-300 px-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30"
                    @if($readonly) disabled @endif
                    @if($required) required @endif>
                    @foreach($options as $optVal => $optText)
                    <option value="{{ $optVal }}" @selected((string)$optVal===(string)$value)>{{ $optText }}</option>
                    @endforeach
                </select>
                @break

                @case('checkbox')
                <label class="inline-flex items-center gap-2">
                    <input type="hidden" name="{{ $name }}" value="0">
                    <input type="checkbox" name="{{ $name }}" id="f-{{ $name }}" value="1"
                        class="h-4 w-4 border-slate-300 rounded"
                        @checked(old($name, $checked ? 1 : 0))
                        @if($readonly) disabled @endif>
                    <span class="text-sm text-slate-700">{{ $placeholder }}</span>
                </label>
                @break

                @default
                {{-- text, email, number, password, date, url... --}}
                <input id="f-{{ $name }}"
                    type="{{ $type }}"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    class="w-full h-11 rounded-md border-slate-300 px-3 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30"
                    placeholder="{{ $placeholder }}"
                    @if($readonly) readonly @endif
                    @if($required) required @endif>
                @endswitch

                @if($help)
                <p class="mt-1 text-xs text-gray-500">{{ $help }}</p>
                @endif

                @error($name)
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>

        <div class="mt-5 flex flex-col-reverse sm:flex-row sm:items-center gap-2">
            <a href="{{ $backUrl }}"
                class="h-11 px-4 rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 flex items-center justify-center">
                Cancel
            </a>
            <button class="h-11 px-5 rounded-md bg-slate-900 text-white hover:brightness-110 flex items-center justify-center">
                {{ $submitText }}
            </button>
        </div>
    </form>
</div>

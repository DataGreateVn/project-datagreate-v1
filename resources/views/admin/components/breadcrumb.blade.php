@props(['items' => []])

<nav class="flex items-center gap-2 text-sm text-slate-500">
    @forelse($items as $i)
    @if(!empty($i['url']))
    <a href="{{ $i['url'] }}" class="hover:text-[#ff8a00]">{{ $i['label'] ?? '' }}</a>
    <span>/</span>
    @else
    <span class="text-slate-800 font-medium">{{ $i['label'] ?? '' }}</span>
    @endif
    @empty
    {{-- không render gì khi rỗng --}}
    @endforelse
</nav>
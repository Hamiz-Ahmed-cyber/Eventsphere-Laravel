@extends('layouts.public')

@section('title', 'Media Gallery')

@section('content')
<section class="max-w-7xl mx-auto px-6 pb-24">

    <div class="mb-10 reveal">
        <h1 class="font-display text-4xl font-bold text-ink-50">Media Gallery</h1>
        <p class="text-ink-300 mt-2">Relive the best moments from fests, competitions, and celebrations.</p>
    </div>

    <div class="flex flex-wrap gap-2 mb-10 reveal">
        <a href="{{ route('gallery.index') }}" class="chip {{ !request('category') ? 'chip-active' : 'chip-inactive' }}">All</a>
        @foreach(['Technical', 'Cultural', 'Sports', 'Workshop', 'Seminar'] as $cat)
            <a href="{{ route('gallery.index', ['category' => $cat]) }}"
               class="chip {{ request('category') === $cat ? 'chip-active' : 'chip-inactive' }}">{{ $cat }}</a>
        @endforeach
    </div>

    <div class="columns-1 sm:columns-2 lg:columns-3 gap-5 space-y-5">
        @forelse(($media ?? []) as $i => $item)
        <div class="card p-0 overflow-hidden reveal tilt-card break-inside-avoid group cursor-pointer"
             style="transition-delay: {{ ($i % 6) * 60 }}ms"
             onclick="openLightbox('{{ addslashes($item->file_url) }}', '{{ addslashes($item->caption ?? $item->event->title) }}')">
            <div class="relative overflow-hidden">
                @if($item->file_type === 'video')
                    <video src="{{ asset('storage/' . $item->file_url) }}" class="w-full h-auto group-hover:scale-105 transition-transform duration-500" muted></video>
                    <span class="absolute top-3 right-3 chip chip-active">▶ Video</span>
                @else
                    <img src="{{ asset('storage/' . $item->file_url) }}" alt="{{ $item->caption }}"
                         class="w-full h-auto group-hover:scale-105 transition-transform duration-500">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-base-950/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                    <div>
                        <p class="public-gallery-title font-medium text-sm">{{ $item->event->title ?? '' }}</p>
                        @if($item->event?->category)
                            <span class="chip chip-active mt-2">{{ $item->event->category }}</span>
                        @endif
                        @if($item->caption)
                            <p class="text-ink-300 text-xs mt-1">{{ $item->caption }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card text-center py-16 text-ink-300 col-span-full">No media uploaded yet — check back after upcoming events.</div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ ($media ?? [])->links() ?? '' }}
    </div>
</section>

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-base-950/90 backdrop-blur-md p-6" onclick="closeLightbox()">
    <div class="max-w-4xl w-full">
        <img id="lightbox-img" src="" alt="" class="w-full rounded-2xl border border-base-700 hidden">
        <video id="lightbox-video" src="" controls class="w-full rounded-2xl border border-base-700 hidden"></video>
        <p id="lightbox-caption" class="text-ink-300 text-center mt-4 text-sm"></p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openLightbox(url, caption) {
        const box = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const cap = document.getElementById('lightbox-caption');
        img.src = '/storage/' + url;
        img.classList.remove('hidden');
        cap.textContent = caption;
        box.classList.remove('hidden');
        box.classList.add('flex');
    }
    function closeLightbox() {
        const box = document.getElementById('lightbox');
        box.classList.add('hidden');
        box.classList.remove('flex');
    }
</script>
@endsection

@extends('layouts.public')

@section('title', 'Events')

@section('content')
<section class="max-w-7xl mx-auto px-6 pb-24">

    <div class="mb-10 reveal">
        <h1 class="font-display text-4xl font-bold text-ink-50">All Events</h1>
        <p class="text-ink-300 mt-2">Browse upcoming, ongoing, and past events across every department.</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('events.index') }}" class="card mb-8 reveal">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="text-xs text-ink-300 mb-1 block">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..."
                       class="w-full px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs text-ink-300 mb-1 block">Category</label>
                <select name="category" class="w-full px-4 py-2.5">
                    <option value="">All Categories</option>
                    @foreach(['Technical', 'Cultural', 'Sports', 'Workshop', 'Seminar'] as $cat)
                        <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-ink-300 mb-1 block">Timing</label>
                <select name="timing" class="w-full px-4 py-2.5">
                    <option value="upcoming" @selected(request('timing', 'upcoming') === 'upcoming')>Upcoming</option>
                    <option value="past" @selected(request('timing') === 'past')>Past</option>
                    <option value="all" @selected(request('timing') === 'all')>All</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn-primary w-full justify-center">Apply Filters</button>
            </div>
        </div>
    </form>

    {{-- Quick category chips --}}
    <div class="flex flex-wrap gap-2 mb-10 reveal">
        <a href="{{ route('events.index') }}" class="chip {{ !request('category') ? 'chip-active' : 'chip-inactive' }}">All</a>
        @foreach(['Technical', 'Cultural', 'Sports', 'Workshop', 'Seminar'] as $cat)
            <a href="{{ route('events.index', array_merge(request()->query(), ['category' => $cat])) }}"
               class="chip {{ request('category') === $cat ? 'chip-active' : 'chip-inactive' }}">{{ $cat }}</a>
        @endforeach
    </div>

    {{-- Results grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse(($events ?? []) as $i => $event)
        <a href="{{ route('events.show', $event->event_id) }}" class="card tilt-card reveal group" style="transition-delay: {{ ($i % 3) * 80 }}ms">
            @if($event->banner_image)
                <img src="{{ asset('storage/' . ltrim($event->banner_image, '/')) }}" alt="{{ $event->title }} banner" class="w-full h-40 object-cover rounded-xl mb-4">
            @endif
            <div class="flex items-center justify-between mb-3">
                <span class="chip chip-active">{{ $event->category }}</span>
                @if($event->event_date->isPast())
                    <span class="text-xs text-ink-500">Past</span>
                @else
                    <span class="badge-approved">Open</span>
                @endif
            </div>
            <h3 class="font-display text-lg font-semibold text-ink-50 group-hover:text-coral-500 transition-colors">
                {{ $event->title }}
            </h3>
            <p class="text-sm text-ink-300 mt-2 line-clamp-2">{{ $event->description }}</p>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-base-700/60 text-xs text-ink-500">
                <span>{{ $event->event_date->format('d M Y') }}</span>
                <span>📍 {{ $event->venue }}</span>
            </div>
        </a>
        @empty
        <div class="card text-center py-16 text-ink-300 md:col-span-3">
            No events match your filters. Try broadening your search.
        </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ ($events ?? [])->links() ?? '' }}
    </div>
</section>
@endsection

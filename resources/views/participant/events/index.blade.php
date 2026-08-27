@extends('layouts.participant')

@section('title', 'Browse Events')

@section('content')

<form method="GET" action="{{ route('participant.events.index') }}" class="p-card mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="text-xs text-slate-500 mb-1 block">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." class="p-input">
        </div>
        <div>
            <label class="text-xs text-slate-500 mb-1 block">Category</label>
            <select name="category" class="p-input">
                <option value="">All Categories</option>
                @foreach(['Technical', 'Cultural', 'Sports', 'Workshop', 'Seminar'] as $cat)
                    <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="p-btn-primary">Filter</button>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    @forelse($events as $event)
    <div class="p-card flex flex-col">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">{{ $event->category }}</span>
            @if($isRegistered[$event->event_id] ?? false)
                <span class="p-badge-confirmed">Registered</span>
            @elseif($event->isFull())
                <span class="p-badge-waitlist">Full</span>
            @endif
        </div>

        <h3 class="font-display font-semibold text-slate-800">{{ $event->title }}</h3>
        <p class="text-sm text-slate-500 mt-1 line-clamp-2 flex-1">{{ $event->description }}</p>

        <div class="text-xs text-slate-500 mt-3 space-y-1">
            <p>📅 {{ $event->event_date->format('d M Y') }} · {{ $event->event_time }}</p>
            <p>📍 {{ $event->venue }}</p>
            <p>{{ $event->seatsAvailable() }} / {{ $event->max_participants }} seats left</p>
        </div>

        <div class="p-progress-track mt-3">
            <div class="p-progress-fill" style="width: {{ $event->max_participants > 0 ? min(100, (($event->max_participants - $event->seatsAvailable()) / $event->max_participants) * 100) : 0 }}%"></div>
        </div>

        <div class="mt-4 flex gap-2">
            <a href="{{ route('events.show', $event->event_id) }}" class="p-btn-outline flex-1">Details</a>

            @if($bookmarks->has($event->event_id))
                <form method="POST" action="{{ route('participant.bookmarks.destroy', $bookmarks[$event->event_id]->bookmark_id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-btn-accent" title="Remove bookmark" aria-label="Remove bookmark">★</button>
                </form>
            @else
                <form method="POST" action="{{ route('participant.bookmarks.store', $event->event_id) }}">
                    @csrf
                    <button type="submit" class="p-btn-outline" title="Save event" aria-label="Save event">☆</button>
                </form>
            @endif

            @if($isRegistered[$event->event_id] ?? false)
                <button class="p-btn-accent flex-1" disabled>✓ Registered</button>
            @elseif($event->isFull() && !$event->waitlist_enabled)
                <button class="p-btn-outline flex-1" disabled>Full</button>
            @else
                <form method="POST" action="{{ route('participant.events.register', $event->event_id) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="p-btn-primary w-full">
                        {{ $event->isFull() ? 'Join Waitlist' : 'Register' }}
                    </button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <div class="p-card text-center py-12 text-slate-500 md:col-span-3">No events match your filters.</div>
    @endforelse
</div>

<div class="mt-8">{{ $events->links() }}</div>
@endsection

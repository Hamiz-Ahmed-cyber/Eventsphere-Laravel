@extends('layouts.participant')

@section('title', 'Bookmarks')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    @forelse($bookmarks as $bookmark)
    <div class="p-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">{{ $bookmark->event->category }}</span>
            <form method="POST" action="{{ route('participant.bookmarks.destroy', $bookmark->bookmark_id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-amber-400 hover:text-amber-500 text-lg" title="Remove bookmark">★</button>
            </form>
        </div>
        <h3 class="font-display font-semibold text-slate-800">{{ $bookmark->event->title }}</h3>
        <p class="text-xs text-slate-500 mt-2">{{ $bookmark->event->event_date->format('d M Y') }} · {{ $bookmark->event->venue }}</p>
        <a href="{{ route('events.show', $bookmark->event->event_id) }}" class="p-btn-outline w-full mt-4">View Event</a>
    </div>
    @empty
    <div class="p-card text-center py-14 text-slate-500 md:col-span-3">
        No bookmarks yet. Star an event to save it here.
    </div>
    @endforelse
</div>
@endsection

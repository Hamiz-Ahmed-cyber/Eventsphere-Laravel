@extends('layouts.organizer')
@section('title', 'Organizer Dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="card-glow"><p class="text-sm text-ink-300">My Events</p><p class="stat-value mt-1">{{ $stats['total_events'] }}</p></div>
    <div class="card"><p class="text-sm text-ink-300">Upcoming</p><p class="stat-value mt-1">{{ $stats['upcoming_events'] }}</p></div>
    <div class="card"><p class="text-sm text-ink-300">Registrations</p><p class="stat-value mt-1">{{ $stats['registrations'] }}</p></div>
    <div class="card"><p class="text-sm text-ink-300">Average Rating</p><p class="stat-value mt-1">{{ $stats['average_rating'] }} / 5</p></div>
</div>
<div class="flex items-center justify-between mb-4"><div><h2 class="font-display text-xl font-semibold text-ink-50">Event Overview</h2><p class="text-sm text-ink-300 mt-1">{{ $stats['pending_events'] }} event(s) awaiting approval</p></div><a href="{{ route('organizer.events.create') }}" class="btn-primary">＋ Create Event</a></div>
<div class="card overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-left text-ink-300 border-b border-base-700"><th class="pb-3">Event</th><th class="pb-3">Date</th><th class="pb-3">Status</th><th class="pb-3">Registrations</th><th class="pb-3">Rating</th></tr></thead><tbody>@forelse($events as $event)<tr class="border-b border-base-700/50"><td class="py-3"><a class="text-ink-50 hover:text-amber-400" href="{{ route('organizer.events.show', $event) }}">{{ $event->title }}</a></td><td class="py-3 text-ink-300">{{ $event->event_date->format('d M Y') }}</td><td class="py-3"><span class="badge-{{ $event->status === 'approved' ? 'approved' : ($event->status === 'rejected' ? 'rejected' : 'pending') }}">{{ ucfirst($event->status) }}</span></td><td class="py-3 text-ink-300">{{ $event->registration_count }}</td><td class="py-3 text-amber-400">{{ number_format($event->feedback_average ?? 0, 1) }} / 5</td></tr>@empty<tr><td colspan="5" class="py-8 text-ink-300">No events yet.</td></tr>@endforelse</tbody></table></div>
@endsection

@extends('layouts.admin')

@section('title', 'Event Review')

@section('content')
    <div class="card max-w-4xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-semibold">{{ $event->title }}</h2>
                <p class="mt-1 text-sm text-ink-700">Submitted by {{ $event->organizer?->name ?? 'Unknown organizer' }}</p>
            </div>
            <span class="badge-pending capitalize">{{ $event->status }}</span>
        </div>
        <dl class="mt-6 grid gap-4 sm:grid-cols-2 text-sm">
            <div><dt class="text-ink-700">Date and time</dt><dd class="font-medium">{{ $event->event_date->format('d M Y') }} at {{ $event->event_time }}</dd></div>
            <div><dt class="text-ink-700">Venue</dt><dd class="font-medium">{{ $event->venue }}</dd></div>
            <div><dt class="text-ink-700">Category</dt><dd class="font-medium">{{ $event->category }}</dd></div>
            <div><dt class="text-ink-700">Maximum participants</dt><dd class="font-medium">{{ $event->max_participants }}</dd></div>
        </dl>
        <div class="mt-6 border-t border-maroon-100 pt-5"><h3 class="font-display text-lg font-semibold">Description</h3><p class="mt-2 whitespace-pre-line text-ink-700">{{ $event->description }}</p></div>
        @if($event->status === 'pending')
            <div class="mt-6 flex gap-3">
                <form method="POST" action="{{ route('admin.events.approve', $event->event_id) }}">@csrf <button class="btn-accent">Approve</button></form>
                <form method="POST" action="{{ route('admin.events.reject', $event->event_id) }}" class="flex gap-2">@csrf <input name="reason" class="rounded-lg border-maroon-200 text-sm" placeholder="Reason (optional)"><button class="btn-outline border-red-400 text-red-500">Reject</button></form>
            </div>
        @endif
    </div>
@endsection

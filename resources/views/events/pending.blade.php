@extends('layouts.admin')

@section('title', 'Event Approvals')

@section('content')
<div class="space-y-4">
    @forelse($pendingEvents as $event)
    <div class="card flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h3 class="font-display text-lg font-semibold">{{ $event->title }}</h3>
                <span class="badge-pending">Pending</span>
            </div>
            <p class="text-sm text-ink-700">
                {{ $event->category }} · {{ $event->event_date->format('d M Y') }} at {{ $event->event_time }} · {{ $event->venue }}
            </p>
            <p class="text-sm text-ink-700 mt-1">Organizer: {{ $event->organizer->name }} · Max participants: {{ $event->max_participants }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.show', $event->event_id) }}" class="btn-outline">View</a>

            <form method="POST" action="{{ route('admin.events.approve', $event->event_id) }}">
                @csrf
                <button type="submit" class="btn-accent">Approve</button>
            </form>

            <button type="button" onclick="document.getElementById('reject-{{ $event->event_id }}').classList.toggle('hidden')"
                    class="btn-outline border-red-400 text-red-500 hover:bg-red-50">Reject</button>
        </div>
    </div>

    <div id="reject-{{ $event->event_id }}" class="hidden card border-red-200">
        <form method="POST" action="{{ route('admin.events.reject', $event->event_id) }}" class="flex gap-3">
            @csrf
            <input type="text" name="reason" placeholder="Reason for rejection (optional)"
                   class="flex-1 rounded-lg border-maroon-200 text-sm">
            <button type="submit" class="btn-primary bg-red-500 hover:bg-red-600">Confirm Reject</button>
        </form>
    </div>
    @empty
    <div class="card text-center py-10 text-ink-700">No events awaiting approval. 🎉</div>
    @endforelse

    {{ $pendingEvents->links() }}
</div>
@endsection

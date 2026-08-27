@extends('layouts.admin')

@section('title', 'Event Approvals')

@section('content')
<div class="space-y-4">
    @forelse($pendingEvents as $event)
    <div class="card flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h3 class="font-display text-lg font-semibold text-ink-50">{{ $event->title }}</h3>
                <span class="badge-pending">Pending</span>
            </div>
            <p class="text-sm text-ink-300">
                {{ $event->category }} · {{ $event->event_date->format('d M Y') }} at {{ $event->event_time }} · {{ $event->venue }}
            </p>
            <p class="text-sm text-ink-300 mt-1">Organizer: {{ $event->organizer->name }} · Max participants: {{ $event->max_participants }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.show', $event->event_id) }}" class="btn-outline">View</a>

            <form method="POST" action="{{ route('admin.events.approve', $event->event_id) }}">
                @csrf
                <button type="submit" class="btn-accent">Approve</button>
            </form>

            <button type="button" onclick="document.getElementById('reject-{{ $event->event_id }}').classList.toggle('hidden')"
                    class="btn-danger">Reject</button>
        </div>
    </div>

    <div id="reject-{{ $event->event_id }}" class="hidden card border-rose-500/30">
        <form method="POST" action="{{ route('admin.events.reject', $event->event_id) }}" class="flex gap-3">
            @csrf
            <input type="text" name="reason" placeholder="Reason for rejection (optional)"
                   class="flex-1 rounded-xl bg-base-900 border-base-600 text-ink-50 text-sm placeholder:text-ink-500 focus:border-violet-500 focus:ring-violet-500">
            <button type="submit" class="btn-danger">Confirm Reject</button>
        </form>
    </div>
    @empty
    <div class="card text-center py-12 text-ink-300">No events awaiting approval. ✦</div>
    @endforelse

    {{ $pendingEvents->links() }}
</div>
@endsection
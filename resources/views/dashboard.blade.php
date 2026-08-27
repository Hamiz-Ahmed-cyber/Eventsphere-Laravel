@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="card-glow">
        <p class="text-sm text-ink-300">Total Users</p>
        <p class="stat-value mt-1">{{ $stats['total_users'] }}</p>
        <p class="text-xs text-ink-300 mt-2">{{ $stats['total_participants'] }} participants · {{ $stats['total_organizers'] }} organizers</p>
    </div>
    <div class="card">
        <p class="text-sm text-ink-300">Events (Approved)</p>
        <p class="text-3xl font-display font-semibold text-lime-400 mt-1">{{ $stats['events_approved'] }}</p>
        <p class="text-xs text-ink-300 mt-2">of {{ $stats['events_total'] }} total events</p>
    </div>
    <div class="card">
        <p class="text-sm text-ink-300">Pending Approval</p>
        <p class="text-3xl font-display font-semibold text-amber-400 mt-1">{{ $stats['events_pending'] }}</p>
        <a href="{{ route('admin.events.pending') }}" class="text-xs text-cyan-400 hover:underline mt-2 inline-block">Review now →</a>
    </div>
    <div class="card">
        <p class="text-sm text-ink-300">Avg Feedback Rating</p>
        <p class="text-3xl font-display font-semibold text-violet-400 mt-1">{{ $stats['avg_feedback_rating'] }} / 5</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card lg:col-span-2">
        <h3 class="font-display text-lg font-semibold mb-4 text-ink-50">Recent Events</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-ink-300 border-b border-base-700">
                    <th class="pb-3 font-medium">Title</th>
                    <th class="pb-3 font-medium">Organizer</th>
                    <th class="pb-3 font-medium">Date</th>
                    <th class="pb-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEvents as $event)
                <tr class="border-b border-base-700/50">
                    <td class="py-3 text-ink-50">{{ $event->title }}</td>
                    <td class="py-3 text-ink-300">{{ $event->organizer->name ?? '—' }}</td>
                    <td class="py-3 text-ink-300">{{ $event->event_date->format('d M Y') }}</td>
                    <td class="py-3">
                        <span class="badge-{{ $event->status === 'approved' ? 'approved' : ($event->status === 'rejected' ? 'rejected' : 'pending') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-6 text-ink-300">No events yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="font-display text-lg font-semibold mb-4 text-ink-50">Top Departments</h3>
        <ul class="space-y-3">
            @forelse($topDepartments as $dept)
            <li class="flex justify-between items-center text-sm">
                <span class="text-ink-300">{{ $dept->department }}</span>
                <span class="font-display font-semibold text-cyan-400">{{ $dept->registration_count }}</span>
            </li>
            @empty
            <li class="text-sm text-ink-300">No data yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
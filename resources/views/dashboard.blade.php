@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="card">
        <p class="text-sm text-ink-700">Total Users</p>
        <p class="text-3xl font-display font-semibold text-maroon-500 mt-1">{{ $stats['total_users'] }}</p>
        <p class="text-xs text-ink-700 mt-2">{{ $stats['total_participants'] }} participants · {{ $stats['total_organizers'] }} organizers</p>
    </div>
    <div class="card">
        <p class="text-sm text-ink-700">Events (Approved)</p>
        <p class="text-3xl font-display font-semibold text-green-600 mt-1">{{ $stats['events_approved'] }}</p>
        <p class="text-xs text-ink-700 mt-2">of {{ $stats['events_total'] }} total events</p>
    </div>
    <div class="card">
        <p class="text-sm text-ink-700">Pending Approval</p>
        <p class="text-3xl font-display font-semibold text-amber-500 mt-1">{{ $stats['events_pending'] }}</p>
        <a href="{{ route('admin.events.pending') }}" class="text-xs text-sky-500 hover:underline mt-2 inline-block">Review now &rarr;</a>
    </div>
    <div class="card">
        <p class="text-sm text-ink-700">Avg Feedback Rating</p>
        <p class="text-3xl font-display font-semibold text-role-admin mt-1">{{ $stats['avg_feedback_rating'] }} / 5</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card lg:col-span-2">
        <h3 class="font-display text-lg font-semibold mb-4">Recent Events</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-ink-700 border-b border-maroon-100">
                    <th class="pb-2">Title</th>
                    <th class="pb-2">Organizer</th>
                    <th class="pb-2">Date</th>
                    <th class="pb-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEvents as $event)
                <tr class="border-b border-maroon-50">
                    <td class="py-2.5">{{ $event->title }}</td>
                    <td class="py-2.5">{{ $event->organizer->name ?? '—' }}</td>
                    <td class="py-2.5">{{ $event->event_date->format('d M Y') }}</td>
                    <td class="py-2.5">
                        <span class="badge-{{ $event->status === 'approved' ? 'approved' : ($event->status === 'rejected' ? 'rejected' : 'pending') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-4 text-ink-700">No events yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="font-display text-lg font-semibold mb-4">Top Departments</h3>
        <ul class="space-y-3">
            @forelse($topDepartments as $dept)
            <li class="flex justify-between text-sm">
                <span>{{ $dept->department }}</span>
                <span class="font-semibold text-maroon-500">{{ $dept->registration_count }}</span>
            </li>
            @empty
            <li class="text-sm text-ink-700">No data yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

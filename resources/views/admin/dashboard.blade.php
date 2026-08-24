@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card">
            <p class="text-sm text-ink-700">Total users</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-ink-700">Approved events</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $stats['events_approved'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-ink-700">Pending approvals</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $stats['events_pending'] }}</p>
            <a class="mt-3 inline-block text-sm font-medium text-maroon-500 hover:text-maroon-700" href="{{ route('admin.events.pending') }}">Review events</a>
        </div>
        <div class="card">
            <p class="text-sm text-ink-700">Average feedback rating</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ number_format($stats['avg_feedback_rating'], 2) }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section class="card">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-display text-xl font-semibold">Recent events</h2>
                <span class="text-sm text-ink-700">{{ $stats['events_total'] }} total</span>
            </div>

            <div class="space-y-3">
                @forelse($recentEvents as $event)
                    <div class="flex items-center justify-between gap-4 border-b border-maroon-100 pb-3 last:border-0 last:pb-0">
                        <div>
                            <p class="font-medium">{{ $event->title }}</p>
                            <p class="text-sm text-ink-700">{{ $event->organizer?->name ?? 'Unknown organizer' }}</p>
                        </div>
                        <span class="text-sm capitalize text-ink-700">{{ $event->status }}</span>
                    </div>
                @empty
                    <p class="text-sm text-ink-700">No events have been created yet.</p>
                @endforelse
            </div>
        </section>

        <section class="card">
            <h2 class="mb-4 font-display text-xl font-semibold">Top departments</h2>
            <div class="space-y-3">
                @forelse($topDepartments as $department)
                    <div class="flex items-center justify-between border-b border-maroon-100 pb-3 last:border-0 last:pb-0">
                        <span class="font-medium">{{ $department->department }}</span>
                        <span class="text-sm text-ink-700">{{ $department->registration_count }} registrations</span>
                    </div>
                @empty
                    <p class="text-sm text-ink-700">No registration data is available yet.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection

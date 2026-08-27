@extends('layouts.participant')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="p-card-highlight">
        <p class="text-sm text-slate-500">Registered Events</p>
        <p class="p-stat-value mt-1">{{ $stats['registered_count'] }}</p>
    </div>
    <div class="p-card">
        <p class="text-sm text-slate-500">Attended</p>
        <p class="p-stat-value-accent mt-1">{{ $stats['attended_count'] }}</p>
    </div>
    <div class="p-card">
        <p class="text-sm text-slate-500">Certificates Earned</p>
        <p class="text-3xl font-display font-bold text-slate-800 mt-1">{{ $stats['certificate_count'] }}</p>
    </div>
    <div class="p-card">
        <p class="text-sm text-slate-500">Bookmarked</p>
        <p class="text-3xl font-display font-bold text-slate-800 mt-1">{{ $stats['bookmark_count'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Upcoming registered events --}}
    <div class="p-card lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display text-lg font-semibold text-slate-800">Your Upcoming Events</h3>
            <a href="{{ route('participant.registrations.index') }}" class="text-xs text-indigo-600 hover:underline">View all →</a>
        </div>

        <div class="space-y-3">
            @forelse($upcomingRegistrations as $reg)
            <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-indigo-200 transition-colors">
                <div>
                    <p class="font-medium text-slate-800 text-sm">{{ $reg->event->title }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $reg->event->event_date->format('d M Y') }} · {{ $reg->event->venue }}</p>
                </div>
                <span class="p-badge-{{ $reg->status === 'confirmed' ? 'confirmed' : 'waitlist' }}">
                    {{ ucfirst($reg->status) }}
                </span>
            </div>
            @empty
            <p class="text-sm text-slate-500 py-6 text-center">No upcoming registrations. <a href="{{ route('participant.events.index') }}" class="text-indigo-600 hover:underline">Browse events →</a></p>
            @endforelse
        </div>
    </div>

    {{-- Notifications / announcements --}}
    <div class="p-card">
        <h3 class="font-display text-lg font-semibold text-slate-800 mb-4">Notifications</h3>
        <div class="space-y-3">
            @forelse($announcements as $a)
            <div class="p-3 rounded-xl bg-indigo-50/60 border border-indigo-100">
                <p class="text-sm font-medium text-slate-800">{{ $a->title }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($a->message, 70) }}</p>
            </div>
            @empty
            <p class="text-sm text-slate-500 text-center py-6">No new notifications.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

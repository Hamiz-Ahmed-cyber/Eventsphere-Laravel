@extends('layouts.public')

@section('title', 'Home')

@section('content')

{{-- ============ HERO ============ --}}
<section class="relative px-6 py-24 md:py-32 overflow-hidden">
    <div class="blob w-96 h-96 bg-indigo-700 -top-20 -left-20"></div>
    <div class="blob w-96 h-96 bg-coral-600 top-40 right-0" style="animation-delay: 2s;"></div>

    <div class="relative max-w-4xl mx-auto text-center reveal">
        <span class="chip chip-active mb-6">✦ TechWiz 6 · College Event Information System</span>
        <h1 class="font-display text-5xl md:text-6xl font-bold leading-tight mt-4">
            Every campus event,<br class="hidden md:block"> <span class="gradient-text">one sphere away.</span>
        </h1>
        <p class="text-ink-300 text-lg mt-6 max-w-2xl mx-auto">
            Stop missing announcements on noticeboards. Discover, register, and relive every technical fest,
            cultural night, and workshop — in real time.
        </p>
        <div class="flex items-center justify-center gap-4 mt-10">
            <a href="{{ route('events.index') }}" class="btn-primary !px-6 !py-3">Explore Events</a>
            <a href="{{ route('register') }}" class="btn-outline !px-6 !py-3">Create Account</a>
        </div>
    </div>
</section>

{{-- ============ ANNOUNCEMENTS TICKER ============ --}}
@if(($announcements ?? collect())->isNotEmpty())
<section class="max-w-7xl mx-auto px-6 mb-20 reveal">
    <div class="card-glow flex items-center gap-4 overflow-hidden">
        <span class="badge-pending shrink-0">Announcement</span>
        <div class="flex-1 overflow-hidden whitespace-nowrap">
            <div class="inline-block animate-[marquee_22s_linear_infinite] text-sm text-ink-300">
                @foreach($announcements as $a)
                    <span class="mx-8 text-ink-50 font-medium">{{ $a->title }}</span> — {{ Str::limit($a->message, 90) }}
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============ UPCOMING EVENTS ============ --}}
<section class="max-w-7xl mx-auto px-6 mb-24">
    <div class="flex items-end justify-between mb-8 reveal">
        <div>
            <h2 class="font-display text-3xl font-bold text-ink-50">Upcoming Events</h2>
            <p class="text-ink-300 mt-1">Events open for registration right now.</p>
        </div>
        <a href="{{ route('events.index') }}" class="nav-link text-coral-500 hidden md:inline-block">View all →</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse(($upcomingEvents ?? []) as $event)
        <a href="{{ route('events.show', $event->event_id) }}" class="card tilt-card reveal group">
            <div class="flex items-center justify-between mb-3">
                <span class="chip chip-active">{{ $event->category }}</span>
                <span class="text-xs text-ink-500">{{ $event->event_date->format('d M') }}</span>
            </div>
            <h3 class="font-display text-lg font-semibold text-ink-50 group-hover:text-coral-500 transition-colors">
                {{ $event->title }}
            </h3>
            <p class="text-sm text-ink-300 mt-2 line-clamp-2">{{ $event->description }}</p>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-base-700/60 text-xs text-ink-500">
                <span>📍 {{ $event->venue }}</span>
                <span>{{ $event->seatsAvailable() }} seats left</span>
            </div>
        </a>
        @empty
        <div class="card text-center py-10 text-ink-300 md:col-span-3">No upcoming events right now — check back soon.</div>
        @endforelse
    </div>
</section>

{{-- ============ PAST HIGHLIGHTS / GALLERY TEASER ============ --}}
<section class="max-w-7xl mx-auto px-6 mb-24 reveal">
    <div class="card-glow relative overflow-hidden text-center py-16">
        <div class="blob w-72 h-72 bg-indigo-700 top-0 left-1/3" style="animation-delay: 1s;"></div>
        <h2 class="font-display text-3xl font-bold text-ink-50 relative">Relive the Best Moments</h2>
        <p class="text-ink-300 mt-3 max-w-xl mx-auto relative">
            Browse photos and videos from past fests, competitions, and celebrations across campus.
        </p>
        <a href="{{ route('gallery.index') }}" class="btn-accent !px-6 !py-3 mt-8 inline-flex relative">Open Gallery</a>
    </div>
</section>

{{-- ============ HOW IT WORKS ============ --}}
<section class="max-w-7xl mx-auto px-6 mb-28">
    <h2 class="font-display text-3xl font-bold text-ink-50 text-center mb-12 reveal">How EventSphere Works</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach([
            ['icon' => '◈', 'title' => 'Discover', 'desc' => 'Browse every upcoming and past event on campus, filtered by department, category, or date.'],
            ['icon' => '◉', 'title' => 'Register', 'desc' => 'Create a free account, register for events in seconds, and get a QR code for check-in.'],
            ['icon' => '◆', 'title' => 'Relive', 'desc' => 'Download your certificate, leave feedback, and browse the event gallery afterward.'],
        ] as $i => $step)
        <div class="card text-center reveal" style="transition-delay: {{ $i * 100 }}ms">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-indigo-600 to-coral-500 flex items-center justify-center text-2xl text-base-950 font-bold mb-4">
                {{ $step['icon'] }}
            </div>
            <h3 class="font-display font-semibold text-ink-50 text-lg">{{ $step['title'] }}</h3>
            <p class="text-sm text-ink-300 mt-2">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

@endsection

@section('scripts')
<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>
@endsection

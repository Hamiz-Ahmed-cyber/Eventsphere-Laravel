@extends('layouts.public')

@section('title', $event->title)

@section('content')
<section class="max-w-5xl mx-auto px-6 pb-24">

    {{-- Banner --}}
    <div class="relative rounded-3xl overflow-hidden h-64 md:h-80 mb-8 reveal bg-gradient-to-br from-violet-600/40 via-base-900 to-cyan-500/30 border border-base-700 flex items-end">
        @if($event->banner_image)
            <img src="{{ asset('storage/' . ltrim($event->banner_image, '/')) }}" alt="{{ $event->title }} banner" class="absolute inset-0 z-0 w-full h-full object-cover">
            <div class="absolute inset-0 z-1 bg-black/55"></div>
        @else
            <div class="blob w-72 h-72 bg-violet-600 -top-10 -left-10"></div>
            <div class="blob w-72 h-72 bg-cyan-500 -bottom-10 right-0" style="animation-delay: 1.5s;"></div>
        @endif
        <div class="relative p-8 z-10">
            <span class="chip chip-active mb-3">{{ $event->category }}</span>
            <h1 class="public-banner-title font-display text-3xl md:text-4xl font-bold">{{ $event->title }}</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Main details --}}
        <div class="md:col-span-2 space-y-6 reveal">
            <div class="card">
                <h2 class="font-display text-lg font-semibold text-ink-50 mb-3">About this event</h2>
                <p class="text-ink-300 leading-relaxed">{{ $event->description }}</p>
            </div>

            <div class="card">
                <h2 class="font-display text-lg font-semibold text-ink-50 mb-4">Details</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-ink-500">Date</p>
                        <p class="text-ink-50 font-medium mt-1">{{ $event->event_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-ink-500">Time</p>
                        <p class="text-ink-50 font-medium mt-1">{{ $event->event_time }}</p>
                    </div>
                    <div>
                        <p class="text-ink-500">Venue</p>
                        <p class="text-ink-50 font-medium mt-1">{{ $event->venue }}</p>
                    </div>
                    <div>
                        <p class="text-ink-500">Organized by</p>
                        <p class="text-ink-50 font-medium mt-1">{{ $event->organizer->name ?? '—' }}</p>
                    </div>
                </div>
            </div>

            @if($event->rulebook)
            <a href="{{ asset('storage/' . $event->rulebook) }}" target="_blank" class="btn-outline">
                📄 Download Rulebook
            </a>
            @endif
        </div>

        {{-- Sidebar: registration card --}}
        <div class="reveal">
            <div class="card-glow sticky top-24">
                <p class="text-sm text-ink-300">Seats available</p>
                <p class="stat-value">{{ $event->seatsAvailable() }} / {{ $event->max_participants }}</p>

                <div class="w-full bg-teal-50 border border-teal-200 rounded-full h-2 mt-4 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-violet-500 to-cyan-400 rounded-full transition-all duration-700"
                         style="width: {{ $event->max_participants > 0 ? min(100, (($event->max_participants - $event->seatsAvailable()) / $event->max_participants) * 100) : 0 }}%"></div>
                </div>

                <div class="mt-6">
                    @if(auth()->check() && auth()->user()->isParticipant() && ($event->event_date->isFuture() || $event->event_date->isToday()))
                        @if($bookmark)
                            <form method="POST" action="{{ route('participant.bookmarks.destroy', $bookmark->bookmark_id) }}" class="mb-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline w-full justify-center">★ Remove from Saved Events</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('participant.bookmarks.store', $event->event_id) }}" class="mb-3">
                                @csrf
                                <button type="submit" class="btn-outline w-full justify-center">☆ Save Upcoming Event</button>
                            </form>
                        @endif
                    @endif
                    @auth
                        @if($event->isFull())
                            <button class="btn-outline w-full justify-center" disabled>Event Full — Join Waitlist</button>
                        @else
                            <form method="POST" action="{{ route('participant.events.register', $event->event_id) }}">
                                @csrf
                                <button type="submit" class="btn-primary w-full justify-center">
                                    Register Now
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login', ['redirect' => route('events.show', $event->event_id)]) }}"
                           class="btn-primary w-full justify-center">
                            Log In to Register
                        </a>
                        <p class="text-xs text-ink-500 text-center mt-3">New here? <a href="{{ route('register') }}" class="text-cyan-400 hover:underline">Create an account</a></p>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-8 reveal">
        <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
            <div>
                <h2 class="font-display text-xl font-semibold text-ink-50">Participant Reviews</h2>
                <p class="text-sm text-ink-300 mt-1">See what attendees thought about this event.</p>
            </div>
            @if($event->feedback->isNotEmpty())
                <p class="text-sm text-amber-400">{{ number_format($event->feedback->avg('rating'), 1) }} / 5 average</p>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($event->feedback as $review)
                <article class="border border-base-700 rounded-xl p-4">
                    <div class="flex justify-between gap-3">
                        <p class="font-medium text-ink-50">{{ $review->student->name ?? 'Participant' }}</p>
                        <span class="text-amber-400">{{ $review->rating }} / 5</span>
                    </div>
                    <p class="text-xs text-ink-500 mt-1">{{ $review->submitted_on?->format('d M Y') }}</p>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 mt-3 text-xs text-ink-300">
                        <span>Organization: {{ $review->organizational_quality ?? '—' }}/5</span>
                        <span>Content: {{ $review->content_relevance ?? '—' }}/5</span>
                        <span>Venue: {{ $review->venue_rating ?? '—' }}/5</span>
                        <span>Coordination: {{ $review->coordination_rating ?? '—' }}/5</span>
                        <span>Technical: {{ $review->technical_arrangements ?? '—' }}/5</span>
                        <span>Hospitality: {{ $review->hospitality_rating ?? '—' }}/5</span>
                    </div>
                    @if($review->comments)
                        <p class="text-sm text-ink-300 mt-3 leading-relaxed">{{ $review->comments }}</p>
                    @endif
                </article>
            @empty
                <p class="text-sm text-ink-300 md:col-span-2">No participant reviews yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
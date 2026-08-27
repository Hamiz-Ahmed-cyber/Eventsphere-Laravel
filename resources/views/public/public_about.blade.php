@extends('layouts.public')

@section('title', 'About Us')

@section('content')
<section class="max-w-4xl mx-auto px-6 pb-24">

    <div class="text-center mb-16 reveal">
        <span class="chip chip-active mb-4">Our Story</span>
        <h1 class="font-display text-4xl font-bold text-ink-50 mt-4">About EventSphere</h1>
        <p class="text-ink-300 mt-4 max-w-2xl mx-auto leading-relaxed">
            EventSphere was built to solve a simple but persistent problem: campus events getting lost
            in noticeboards, group chats, and word-of-mouth. We centralize everything — discovery,
            registration, attendance, and feedback — into one platform.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        @foreach([
            ['num' => '01', 'title' => 'Discover Easily', 'desc' => 'Every upcoming and past event, searchable and filterable in one place.'],
            ['num' => '02', 'title' => 'Register in Seconds', 'desc' => 'No paperwork. Register online and get a QR code for instant check-in.'],
            ['num' => '03', 'title' => 'Stay Informed', 'desc' => 'Real-time announcements and updates for every event you\'re part of.'],
        ] as $i => $item)
        <div class="card reveal" style="transition-delay: {{ $i * 100 }}ms">
            <span class="font-display text-3xl font-bold text-indigo-600/30">{{ $item['num'] }}</span>
            <h3 class="font-display font-semibold text-ink-50 text-lg mt-2">{{ $item['title'] }}</h3>
            <p class="text-sm text-ink-300 mt-2">{{ $item['desc'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="card-glow text-center reveal">
        <h2 class="font-display text-2xl font-bold text-ink-50">Built for TechWiz 6</h2>
        <p class="text-ink-300 mt-3 max-w-xl mx-auto">
            This platform was developed as part of Aptech's TechWiz 6 Global AI-Based Tech Competition,
            under the College Event Information System theme.
        </p>
    </div>
</section>
@endsection

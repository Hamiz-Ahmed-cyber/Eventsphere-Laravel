@extends('layouts.public')

@section('title', 'FAQs')

@section('content')
<section class="max-w-3xl mx-auto px-6 pb-24">

    <div class="text-center mb-12 reveal">
        <h1 class="font-display text-4xl font-bold text-ink-50">Frequently Asked Questions</h1>
        <p class="text-ink-300 mt-3">Everything you need to know about using EventSphere.</p>
    </div>

    <div class="space-y-3">
        @foreach([
            ['q' => 'Do I need an account to browse events?', 'a' => 'No — anyone can browse upcoming and past events, view details, and explore the media gallery without logging in. An account is only required to register for an event, submit feedback, or download a certificate.'],
            ['q' => 'How do I register for an event?', 'a' => 'Log in or create a free account, open the event you\'re interested in, and click "Register Now." You\'ll receive a QR code used for check-in on the day of the event.'],
            ['q' => 'What happens if an event is full?', 'a' => 'If waitlisting is enabled for that event, you can join the waitlist. If a registered participant cancels, waitlisted users are automatically moved into the open slot.'],
            ['q' => 'How do I get my certificate?', 'a' => 'After attending an event (verified via QR check-in), your certificate becomes available for download from your dashboard once the organizer issues it.'],
            ['q' => 'Can I cancel my registration?', 'a' => 'Yes, as long as it\'s before the event\'s cancellation cutoff date and the event allows cancellations. You can cancel from your participant dashboard.'],
            ['q' => 'Who approves new events?', 'a' => 'Events created by organizers enter a "Pending Approval" state and only go live on the public site once reviewed and approved by an admin.'],
        ] as $i => $item)
        <div class="card reveal cursor-pointer" style="transition-delay: {{ $i * 60 }}ms" onclick="this.querySelector('.faq-a').classList.toggle('hidden'); this.querySelector('.faq-icon').classList.toggle('rotate-45')">
            <div class="flex items-center justify-between">
                <h3 class="font-display font-semibold text-ink-50">{{ $item['q'] }}</h3>
                <span class="faq-icon text-indigo-400 text-xl transition-transform duration-300 shrink-0 ml-4">+</span>
            </div>
            <p class="faq-a hidden text-sm text-ink-300 mt-3 leading-relaxed">{{ $item['a'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="card-glow text-center mt-12 reveal">
        <p class="text-ink-50 font-display font-semibold">Still have questions?</p>
        <a href="{{ route('contact') }}" class="btn-primary mt-4 inline-flex">Contact Support</a>
    </div>
</section>
@endsection

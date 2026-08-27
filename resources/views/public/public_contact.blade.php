@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<section class="max-w-3xl mx-auto px-6 pb-24">

    <div class="text-center mb-12 reveal">
        <h1 class="font-display text-4xl font-bold text-ink-50">Get in Touch</h1>
        <p class="text-ink-300 mt-3">Questions, suggestions, or issues — we'd love to hear from you.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-lime-400/10 border border-lime-400/30 text-lime-400 text-sm reveal">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.submit') }}" class="card space-y-5 reveal">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-xs text-ink-300 mb-1 block">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5">
                @error('name') <p class="text-xs text-rose-400 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-xs text-ink-300 mb-1 block">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5">
                @error('email') <p class="text-xs text-rose-400 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div>
            <label class="text-xs text-ink-300 mb-1 block">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2.5">
        </div>
        <div>
            <label class="text-xs text-ink-300 mb-1 block">Message</label>
            <textarea name="message" rows="5" required class="w-full px-4 py-2.5">{{ old('message') }}</textarea>
            @error('message') <p class="text-xs text-rose-400 mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn-primary w-full justify-center !py-3">Send Message</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-10">
        <div class="card text-center reveal">
            <p class="text-2xl mb-2">✉</p>
            <p class="text-sm text-ink-50 font-medium">Email</p>
            <p class="text-xs text-ink-300 mt-1">support@eventsphere.test</p>
        </div>
        <div class="card text-center reveal" style="transition-delay: 100ms">
            <p class="text-2xl mb-2">☏</p>
            <p class="text-sm text-ink-50 font-medium">Phone</p>
            <p class="text-xs text-ink-300 mt-1">+92 300 0000000</p>
        </div>
        <div class="card text-center reveal" style="transition-delay: 200ms">
            <p class="text-2xl mb-2">⌂</p>
            <p class="text-sm text-ink-50 font-medium">Campus Office</p>
            <p class="text-xs text-ink-300 mt-1">Student Affairs Block, Room 12</p>
        </div>
    </div>
</section>
@endsection

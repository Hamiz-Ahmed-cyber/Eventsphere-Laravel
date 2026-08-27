@extends('layouts.public')

@section('title', 'Sitemap')

@section('content')
<section class="max-w-4xl mx-auto px-6 pb-24">

    <div class="text-center mb-14 reveal">
        <h1 class="font-display text-4xl font-bold text-ink-50">Sitemap</h1>
        <p class="text-ink-300 mt-3">A full map of EventSphere's structure and navigation flow.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="card reveal">
            <h3 class="font-display font-semibold text-coral-500 mb-4">Public Pages</h3>
            <ul class="space-y-2 text-sm text-ink-300">
                <li><a href="{{ route('home') }}" class="hover:text-ink-50 transition-colors">→ Home</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-ink-50 transition-colors">→ All Events</a></li>
                <li><a href="{{ route('gallery.index') }}" class="hover:text-ink-50 transition-colors">→ Media Gallery</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-ink-50 transition-colors">→ About Us</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-ink-50 transition-colors">→ Contact Us</a></li>
                <li><a href="{{ route('faq') }}" class="hover:text-ink-50 transition-colors">→ FAQs</a></li>
            </ul>
        </div>

        <div class="card reveal" style="transition-delay: 80ms">
            <h3 class="font-display font-semibold text-lime-400 mb-4">Account</h3>
            <ul class="space-y-2 text-sm text-ink-300">
                <li><a href="{{ route('login') }}" class="hover:text-ink-50 transition-colors">→ Log In</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-ink-50 transition-colors">→ Sign Up</a></li>
                <li class="text-ink-500">→ Password Reset</li>
            </ul>

            <h3 class="font-display font-semibold text-lime-400 mb-4 mt-6">Participant Panel</h3>
            <ul class="space-y-2 text-sm text-ink-300">
                <li class="text-ink-500">→ Dashboard</li>
                <li class="text-ink-500">→ My Registrations</li>
                <li class="text-ink-500">→ Certificates</li>
                <li class="text-ink-500">→ Feedback</li>
            </ul>
        </div>

        <div class="card reveal" style="transition-delay: 160ms">
            <h3 class="font-display font-semibold text-amber-400 mb-4">Organizer Panel</h3>
            <ul class="space-y-2 text-sm text-ink-300">
                <li class="text-ink-500">→ Dashboard</li>
                <li class="text-ink-500">→ Create / Manage Events</li>
                <li class="text-ink-500">→ Registrations & Attendance</li>
                <li class="text-ink-500">→ Certificates & Media</li>
            </ul>
        </div>

        <div class="card reveal" style="transition-delay: 240ms">
            <h3 class="font-display font-semibold text-indigo-400 mb-4">Admin Panel</h3>
            <ul class="space-y-2 text-sm text-ink-300">
                <li class="text-ink-500">→ Dashboard</li>
                <li class="text-ink-500">→ Event Approvals</li>
                <li class="text-ink-500">→ User Management</li>
                <li class="text-ink-500">→ Content Moderation</li>
                <li class="text-ink-500">→ Announcements</li>
                <li class="text-ink-500">→ Reports</li>
            </ul>
        </div>

    </div>
</section>
@endsection

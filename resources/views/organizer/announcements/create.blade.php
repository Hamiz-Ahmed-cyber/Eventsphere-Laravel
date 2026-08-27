@extends('layouts.organizer')

@section('title', 'Send Announcement')

@section('content')
<div class="max-w-2xl card">
    <p class="text-sm text-ink-300 mb-6">
        This message will be visible to participants registered for
        <span class="text-ink-50">{{ $event->title }}</span>.
    </p>

    <form method="POST" action="{{ route('organizer.announcements.store', $event) }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm text-ink-300 mb-1">Title</label>
            <input name="title" value="{{ old('title') }}" required maxlength="255" class="organizer-event-field w-full">
        </div>
        <div>
            <label class="block text-sm text-ink-300 mb-1">Message</label>
            <textarea name="message" rows="7" required maxlength="5000" class="w-full">{{ old('message') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button class="btn-accent" type="submit">Send to Participants</button>
            <a href="{{ route('organizer.events.show', $event) }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection

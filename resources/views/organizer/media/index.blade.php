@extends('layouts.organizer')

@section('title', 'Media Gallery')

@section('content')
<div class="max-w-2xl card mb-8">
    <h2 class="font-display text-lg font-semibold mb-4">Upload event media</h2>
    <form method="POST" action="{{ route('organizer.media.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-ink-300 mb-1">Event</label>
            <select name="event_id" required class="w-full">
                <option value="">Select an event</option>
                @foreach($events as $event)
                    <option value="{{ $event->event_id }}">{{ $event->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-ink-300 mb-1">Photo or video</label>
            <input type="file" name="file" accept="image/*,video/*" required class="w-full">
        </div>
        <div>
            <label class="block text-sm text-ink-300 mb-1">Caption</label>
            <input name="caption" maxlength="150" class="organizer-event-field w-full">
        </div>
        <button class="btn-primary" type="submit">Upload Media</button>
    </form>
</div>

@foreach($events as $event)
<div class="mb-8">
    <h2 class="font-display text-lg font-semibold mb-3">{{ $event->title }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($event->media as $media)
        <div class="card">
            @if($media->file_type === 'image')
                <img src="{{ asset('storage/'.$media->file_url) }}" alt="{{ $media->caption ?? $event->title }}" class="w-full h-40 object-cover rounded-xl">
            @else
                <video src="{{ asset('storage/'.$media->file_url) }}" controls class="w-full h-40 object-cover rounded-xl"></video>
            @endif
            <p class="text-sm text-ink-300 mt-3">{{ $media->caption }}</p>
            <form method="POST" action="{{ route('organizer.media.destroy', $media) }}" class="mt-3">
                @csrf
                @method('DELETE')
                <button class="btn-danger !py-1" onclick="return confirm('Delete this upload?')">Delete</button>
            </form>
        </div>
        @empty
            <p class="text-sm text-ink-300">No uploads for this event.</p>
        @endforelse
    </div>
</div>
@endforeach
@endsection

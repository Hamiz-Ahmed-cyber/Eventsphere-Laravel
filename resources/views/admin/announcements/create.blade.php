@extends('layouts.admin')
@section('title', 'Create Announcement')
@section('content')
<form method="POST" action="{{ route('admin.announcements.store') }}" class="card max-w-2xl space-y-5">@csrf
    <div><label class="block text-sm font-medium">Title</label><input required name="title" value="{{ old('title') }}" class="mt-1 w-full rounded-lg border-maroon-200"></div>
    <div><label class="block text-sm font-medium">Message</label><textarea required name="message" rows="6" class="mt-1 w-full rounded-lg border-maroon-200">{{ old('message') }}</textarea></div>
    <div><label class="block text-sm font-medium">Audience</label><select required name="target_role" class="mt-1 w-full rounded-lg border-maroon-200">@foreach(['all' => 'Everyone', 'participant' => 'Participants', 'organizer' => 'Organizers'] as $value => $label)<option value="{{ $value }}" @selected(old('target_role') === $value)>{{ $label }}</option>@endforeach</select></div>
    <div><label class="block text-sm font-medium">Related event (optional)</label><select name="event_id" class="mt-1 w-full rounded-lg border-maroon-200"><option value="">None</option>@foreach($events as $event)<option value="{{ $event->event_id }}">{{ $event->title }}</option>@endforeach</select></div>
    <button class="btn-primary">Send announcement</button>
</form>
@endsection

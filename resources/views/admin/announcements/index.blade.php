@extends('layouts.admin')
@section('title', 'Announcements')
@section('content')
<div class="mb-6"><a class="btn-primary" href="{{ route('admin.announcements.create') }}">Create announcement</a></div>
<div class="space-y-4">@forelse($announcements as $announcement)<article class="card"><div class="flex justify-between gap-4"><div><h2 class="font-display text-xl font-semibold">{{ $announcement->title }}</h2><p class="mt-2 whitespace-pre-line text-ink-700">{{ $announcement->message }}</p></div><span class="text-sm capitalize text-ink-700">To: {{ $announcement->target_role }}</span></div><p class="mt-3 text-xs text-ink-700">Sent by {{ $announcement->sender?->name ?? 'Unknown' }}{{ $announcement->event ? ' · '.$announcement->event->title : '' }}</p></article>@empty<div class="card text-ink-700">No announcements have been sent.</div>@endforelse{{ $announcements->links() }}</div>
@endsection

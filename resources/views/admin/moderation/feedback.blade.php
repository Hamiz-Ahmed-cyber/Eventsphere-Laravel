@extends('layouts.admin')
@section('title', 'Feedback Moderation')
@section('content')
<div class="space-y-4">@forelse($feedback as $item)<article class="card"><div class="flex justify-between gap-4"><div><p class="font-medium">{{ $item->event?->title ?? 'Deleted event' }} · {{ $item->rating }}/5</p><p class="text-sm text-ink-700">{{ $item->student?->name ?? 'Deleted user' }} · {{ $item->submitted_on }}</p><p class="mt-2">{{ $item->comments ?: 'No comment provided.' }}</p></div><div class="flex h-fit gap-2">@foreach(['visible','flagged','removed'] as $status)<form method="POST" action="{{ route('admin.moderation.feedback.status', [$item, $status]) }}">@csrf @method('PATCH')<button class="text-sm text-maroon-500">{{ ucfirst($status) }}</button></form>@endforeach</div></div></article>@empty<div class="card text-ink-700">No feedback to moderate.</div>@endforelse{{ $feedback->links() }}</div>
@endsection

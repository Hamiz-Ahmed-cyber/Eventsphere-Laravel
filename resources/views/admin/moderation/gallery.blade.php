@extends('layouts.admin')
@section('title', 'Gallery Moderation')
@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">@forelse($media as $item)<article class="card"><a href="{{ $item->file_url }}" target="_blank" class="font-medium text-maroon-500">Open {{ $item->file_type }}</a><p class="mt-2 text-sm">{{ $item->caption ?: 'No caption' }}</p><p class="mt-1 text-sm text-ink-700">{{ $item->event?->title ?? 'Deleted event' }} · {{ $item->uploader?->name ?? 'Deleted user' }}</p><div class="mt-4 flex gap-3">@foreach(['visible','flagged','removed'] as $status)<form method="POST" action="{{ route('admin.moderation.gallery.status', [$item, $status]) }}">@csrf @method('PATCH')<button class="text-sm text-maroon-500">{{ ucfirst($status) }}</button></form>@endforeach</div></article>@empty<div class="card text-ink-700">No media to moderate.</div>@endforelse</div><div class="mt-4">{{ $media->links() }}</div>
@endsection

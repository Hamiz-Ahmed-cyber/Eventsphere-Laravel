@extends('layouts.admin')

@section('title', 'Visitor Inquiries')

@section('content')
<div class="space-y-6">
    @forelse($messages as $msg)
    <div class="card relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="space-y-2 flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <span class="font-display font-semibold text-ink-50 text-base">{{ $msg->subject }}</span>
                @if($msg->status === 'unread')
                    <span class="badge-pending">New</span>
                @endif
            </div>
            <p class="text-xs text-ink-300">
                From: <span class="font-semibold text-violet-400">{{ $msg->name }}</span> ({{ $msg->email }}) · Received {{ $msg->created_at->format('d M Y, h:i A') }}
            </p>
            <p class="text-sm text-ink-700 bg-base-950/40 p-4 rounded-xl border border-base-800 leading-relaxed whitespace-pre-wrap">
                {{ $msg->message }}
            </p>
        </div>

        <div>
            <form method="POST" action="{{ route('admin.contacts.destroy', $msg->id) }}" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger whitespace-nowrap">
                    🗑 Delete Message
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="card text-center py-16 text-ink-300">
        No visitor messages have been received yet. ✦
    </div>
    @endforelse

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection

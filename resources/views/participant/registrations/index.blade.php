@extends('layouts.participant')

@section('title', 'My Registrations')

@section('content')

<div class="space-y-4">
    @forelse($registrations as $reg)
    <div class="p-card flex items-center justify-between flex-wrap gap-4">
        <div class="flex-1 min-w-[240px]">
            <div class="flex items-center gap-2 mb-1">
                <h3 class="font-display font-semibold text-slate-800">{{ $reg->event->title }}</h3>
                <span class="p-badge-{{ $reg->status === 'confirmed' ? 'confirmed' : ($reg->status === 'cancelled' ? 'cancelled' : 'waitlist') }}">
                    {{ ucfirst($reg->status) }}
                </span>
                @if($reg->attendance && $reg->attendance->attended)
                    <span class="p-badge-attended">Attended</span>
                @endif
            </div>
            <p class="text-sm text-slate-500">
                {{ $reg->event->event_date->format('d M Y') }} · {{ $reg->event->event_time }} · {{ $reg->event->venue }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if($reg->status === 'confirmed' && $reg->attendance?->attended)
                <a href="{{ route('participant.feedback.create', $reg->event_id) }}" class="p-btn-outline">{{ $reg->event->feedback()->where('student_id', auth()->id())->exists() ? 'Update Feedback' : 'Leave Feedback' }}</a>
            @endif

            @if($reg->status === 'confirmed' && $reg->event->event_date->isFuture())
                <button type="button"
                        onclick="document.getElementById('qr-{{ $reg->registration_id }}').classList.toggle('hidden')"
                        class="p-btn-outline">Show QR</button>
            @endif

            @if($reg->status === 'confirmed' && $reg->event->cancellation_allowed && $reg->event->event_date->isFuture())
                <form method="POST" action="{{ route('participant.registrations.cancel', $reg->registration_id) }}"
                      onsubmit="return confirm('Cancel this registration?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="p-btn-danger">Cancel</button>
                </form>
            @endif
        </div>
    </div>

    @if($reg->status === 'confirmed')
    <div id="qr-{{ $reg->registration_id }}" class="hidden p-card text-center">
        <p class="text-sm text-slate-500 mb-3">Show this QR code at check-in</p>
        <img src="data:image/svg+xml;base64,{{ $reg->qr_code_image ?? '' }}" alt="QR Code" ...>
        <p class="text-xs text-slate-400 mt-2">Code: {{ $reg->qr_code }}</p>
    </div>
    @endif
    @empty
    <div class="p-card text-center py-14 text-slate-500">
        You haven't registered for any events yet.
        <a href="{{ route('participant.events.index') }}" class="text-indigo-600 hover:underline block mt-2">Browse events →</a>
    </div>
    @endforelse

    {{ $registrations->links() }}
</div>
@endsection

@extends('layouts.participant')

@section('title', 'Certificates')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    @forelse($certificates as $cert)
    <div class="p-card flex items-center justify-between">
        <div>
            <h3 class="font-display font-semibold text-slate-800">{{ $cert->event->title }}</h3>
            <p class="text-xs text-slate-500 mt-1">Issued on {{ \Carbon\Carbon::parse($cert->issued_on)->format('d M Y') }}</p>
            @if($cert->event->certificate_fee > 0)
                <p class="text-xs mt-1 {{ $cert->fee_paid ? 'text-green-600' : 'text-amber-600' }}">
                    {{ $cert->fee_paid ? '✓ Fee Paid' : '⚠ Fee Pending (Rs. ' . number_format($cert->event->certificate_fee, 0) . ')' }}
                </p>
            @endif
        </div>

        @if($cert->fee_paid || $cert->event->certificate_fee == 0)
            <a href="{{ asset('storage/' . $cert->certificate_url) }}" target="_blank" class="p-btn-accent">⬇ Download</a>
        @else
            <a href="{{ route('participant.certificates.pay', $cert->certificate_id) }}" class="p-btn-primary">Pay Fee</a>
        @endif
    </div>
    @empty
    <div class="p-card text-center py-14 text-slate-500 md:col-span-2">
        No certificates yet — attend an event to earn one.
    </div>
    @endforelse
</div>

<div class="mt-8">{{ $certificates->links() }}</div>
@endsection

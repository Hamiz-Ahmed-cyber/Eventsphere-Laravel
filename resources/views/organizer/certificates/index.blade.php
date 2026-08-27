@extends('layouts.organizer')

@section('title', 'Certificates')

@section('content')
<div class="max-w-3xl card mb-6">
    <h2 class="font-display text-lg font-semibold mb-2">Issue certificates</h2>
    <p class="text-sm text-ink-300 mb-5">Upload one certificate template and choose exactly which checked-in attendees should receive it.</p>

    <form method="POST" action="{{ route('organizer.certificates.store', $event) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-5">
            <label class="block text-sm text-ink-300 mb-1">Certificate template</label>
            <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png" required class="w-full">
        </div>

        <div class="border-t border-base-700 pt-5">
            <div class="flex items-center justify-between gap-3 mb-3">
                <div>
                    <h3 class="font-display font-semibold text-ink-50">Choose attendees</h3>
                    <p class="text-xs text-ink-300 mt-1">Only attendees who checked in are listed. If this event has a certificate fee, the attendee must also have a paid certificate stub.</p>
                </div>
                <span class="text-sm text-amber-500">{{ $eligibleAttendees->count() }} eligible</span>
            </div>

            <div class="space-y-2">
                @forelse($eligibleAttendees as $registration)
                    <label class="flex items-center justify-between gap-3 rounded-xl border border-base-700 px-4 py-3 hover:border-teal-400">
                        <span class="flex items-center gap-3">
                            <input type="checkbox" name="student_ids[]" value="{{ $registration->student_id }}" @checked(in_array($registration->student_id, old('student_ids', [])))>
                            <span>
                                <span class="block text-sm text-ink-50">{{ $registration->student->name }}</span>
                                <span class="block text-xs text-ink-300">{{ $registration->student->details->department ?? 'Department not provided' }}</span>
                            </span>
                        </span>
                        <span class="text-xs text-lime-600">Attended</span>
                    </label>
                @empty
                    <p class="text-sm text-ink-300 rounded-xl border border-base-700 px-4 py-4">No eligible attendees are available for this event.</p>
                @endforelse
            </div>
        </div>

        <button class="btn-primary mt-5" type="submit" @disabled($eligibleAttendees->isEmpty())>Issue to Selected Attendees</button>
    </form>
</div>

<div class="card overflow-x-auto">
    <h2 class="font-display text-lg font-semibold mb-4">Certificate records</h2>
    <table class="w-full text-sm">
        <thead><tr class="text-left text-ink-300 border-b border-base-700"><th class="pb-3">Participant</th><th class="pb-3">Fee</th><th class="pb-3">Certificate</th></tr></thead>
        <tbody>
            @forelse($event->certificates as $certificate)
                <tr class="border-b border-base-700/50">
                    <td class="py-3 text-ink-50">{{ $certificate->student->name }}</td>
                    <td class="py-3 text-ink-300">{{ $certificate->fee_paid ? 'Paid' : ($event->certificate_fee == 0 ? 'Free' : 'Pending') }}</td>
                    <td class="py-3">
                        @if($certificate->certificate_url)
                            <a class="text-teal-600 hover:underline" href="{{ asset('storage/'.$certificate->certificate_url) }}" target="_blank">View file</a>
                        @else
                            <span class="text-ink-300">Not issued</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="py-6 text-ink-300">No certificate records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

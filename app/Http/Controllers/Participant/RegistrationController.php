<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\EventWaitlist;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('event', 'event.organizer')
            ->where('student_id', Auth::id())
            ->orderByDesc('registered_on')
            ->paginate(10);

        foreach ($registrations as $reg) {
            if ($reg->status === 'confirmed' && $reg->qr_code) {
                // SVG format needs neither GD nor Imagick — pure PHP rendering,
                // so it works out of the box on any XAMPP/Windows setup.
                $reg->qr_code_image = base64_encode(
                    QrCode::format('svg')->size(220)->margin(1)->generate($reg->qr_code)
                );
            } else {
                $reg->qr_code_image = null;
            }
        }

        return view('participant.registrations.index', compact('registrations'));
    }

    public function cancel(Registration $registration)
    {
        abort_unless($registration->student_id === Auth::id(), 403);

        if (! $registration->event->cancellation_allowed) {
            return back()->with('error', 'Cancellation is not allowed for this event.');
        }

        $registration->update(['status' => 'cancelled']);

        $seating = $registration->event->seating;
        if ($seating && $seating->seats_booked > 0) {
            $seating->decrement('seats_booked');
        }

        // Promote the earliest waitlisted user into the freed slot
        $nextInLine = EventWaitlist::where('event_id', $registration->event_id)
            ->where('status', 'waiting')
            ->orderBy('waitlist_time')
            ->first();

        if ($nextInLine) {
            Registration::create([
                'event_id' => $registration->event_id,
                'student_id' => $nextInLine->user_id,
                'status' => 'confirmed',
                'qr_code' => \Illuminate\Support\Str::uuid(),
            ]);
            $nextInLine->update(['status' => 'confirmed']);
            $seating?->increment('seats_booked');

            // TODO: notify $nextInLine->user about their confirmed spot
        }

        return back()->with('success', 'Registration cancelled.');
    }
}
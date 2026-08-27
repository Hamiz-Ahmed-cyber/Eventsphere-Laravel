<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use App\Models\EventWaitlist;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;

class RegistrationController extends OrganizerController
{
    public function update(Request $request, Registration $registration)
    {
        $registration->load('event');
        $this->authorizeEvent($registration->event);

        $data = $request->validate(['status' => ['required', 'in:confirmed,cancelled']]);

        if ($data['status'] === 'confirmed' && $registration->status !== 'confirmed') {
            $seating = $registration->event->seating;
            if ($seating && $seating->seats_booked >= $seating->total_seats) {
                return back()->with('error', 'There are no seats available for this registration.');
            }
        }

        DB::transaction(function () use ($registration, $data) {
            $wasConfirmed = $registration->status === 'confirmed';
            $registration->update($data);

            if (! $wasConfirmed && $data['status'] === 'confirmed') {
                $registration->event->seating?->increment('seats_booked');
            }

            if ($wasConfirmed && $data['status'] === 'cancelled') {
                $seating = $registration->event->seating;
                if ($seating && $seating->seats_booked > 0) {
                    $seating->decrement('seats_booked');
                }

                $next = EventWaitlist::where('event_id', $registration->event_id)
                    ->where('status', 'waiting')->orderBy('waitlist_time')->first();
                if ($next) {
                    Registration::create([
                        'event_id' => $registration->event_id,
                        'student_id' => $next->user_id,
                        'status' => 'confirmed',
                        'qr_code' => Str::uuid(),
                    ]);
                    $next->update(['status' => 'confirmed']);
                    $seating?->increment('seats_booked');
                }
            }
        });

        return back()->with('success', 'Registration status updated.');
    }
}

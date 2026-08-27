<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Event;
use App\Models\EventSeating;
use App\Models\EventWaitlist;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::approved()->upcoming();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $events = $query->orderBy('event_date')->paginate(9)->withQueryString();

        $userId = Auth::id();
        $isRegistered = Registration::where('student_id', $userId)
            ->where('status', '!=', 'cancelled')
            ->whereIn('event_id', $events->pluck('event_id'))
            ->pluck('event_id')
            ->flip()
            ->map(fn () => true)
            ->toArray();

        $bookmarks = Bookmark::where('user_id', $userId)
            ->whereIn('event_id', $events->pluck('event_id'))
            ->get()
            ->keyBy('event_id');

        return view('participant.events.index', compact('events', 'isRegistered', 'bookmarks'));
    }

    public function register(Event $event)
    {
        $userId = Auth::id();

        $existing = Registration::where('event_id', $event->event_id)
            ->where('student_id', $userId)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $seating = EventSeating::firstOrCreate(
            ['event_id' => $event->event_id],
            ['total_seats' => $event->max_participants, 'seats_booked' => 0, 'waitlist_enabled' => $event->waitlist_enabled]
        );

        if ($seating->seats_booked >= $seating->total_seats) {
            if (! $event->waitlist_enabled) {
                return back()->with('error', 'This event is full and waitlisting is not enabled.');
            }

            EventWaitlist::create([
                'user_id' => $userId,
                'event_id' => $event->event_id,
                'status' => 'waiting',
            ]);

            return back()->with('success', 'Event is full — you\'ve been added to the waitlist.');
        }

        Registration::create([
            'event_id' => $event->event_id,
            'student_id' => $userId,
            'status' => 'confirmed',
            'qr_code' => Str::uuid(),
        ]);

        $seating->increment('seats_booked');

        return back()->with('success', 'Registered successfully! Find your QR code under My Registrations.');
    }
}

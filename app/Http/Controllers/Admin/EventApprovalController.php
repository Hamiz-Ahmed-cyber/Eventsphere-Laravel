<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSeating;
use Illuminate\Http\Request;

class EventApprovalController extends Controller
{
    public function index()
    {
        $pendingEvents = Event::with('organizer')
            ->pending()
            ->orderBy('event_date')
            ->paginate(10);

        return view('events.pending', compact('pendingEvents'));
    }

    public function show(Event $event)
    {
        $event->load('organizer', 'seating');

        return view('admin.events.show', compact('event'));
    }

    public function approve(Event $event)
    {
        $event->update(['status' => 'approved']);

        // Ensure a seating row exists once the event goes live
        EventSeating::firstOrCreate(
            ['event_id' => $event->event_id],
            ['total_seats' => $event->max_participants, 'seats_booked' => 0, 'waitlist_enabled' => $event->waitlist_enabled]
        );

        // TODO: notify organizer (announcement / email)

        return back()->with('success', "\"{$event->title}\" has been approved and is now live.");
    }

    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $event->update(['status' => 'rejected']);

        // TODO: notify organizer with $request->reason

        return back()->with('success', "\"{$event->title}\" has been rejected.");
    }
}

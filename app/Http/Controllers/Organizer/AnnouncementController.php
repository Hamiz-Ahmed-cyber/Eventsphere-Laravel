<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Announcement;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends OrganizerController
{
    public function create(Event $event)
    {
        $this->authorizeEvent($event);
        return view('organizer.announcements.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);
        Announcement::create($data + [
            'sent_by' => Auth::id(), 'target_role' => 'participant', 'event_id' => $event->event_id,
        ]);
        return redirect()->route('organizer.events.show', $event)->with('success', 'Announcement sent to registered participants.');
    }
}

<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\EventSeating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends OrganizerController
{
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())
            ->withCount('registrations')
            ->orderByDesc('event_date')
            ->paginate(10);

        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        return view('organizer.events.create');
    }

    public function store(Request $request)
    {
        $event = Event::create($this->validatedData($request) + [
            'organizer_id' => Auth::id(),
            'status' => 'pending',
        ]);

        EventSeating::create([
            'event_id' => $event->event_id,
            'total_seats' => $event->max_participants,
            'seats_booked' => 0,
            'waitlist_enabled' => $event->waitlist_enabled,
        ]);

        return redirect()->route('organizer.events.index')->with('success', 'Event submitted for admin approval.');
    }

    public function show(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load(['registrations.student.details', 'attendance.student', 'feedback.student']);

        return view('organizer.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorizeEvent($event);
        abort_if($event->event_date->isPast(), 403, 'Past events cannot be edited.');

        return view('organizer.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        abort_if($event->event_date->isPast(), 403, 'Past events cannot be edited.');

        $oldDate = $event->event_date->toDateString();
        $event->update($this->validatedData($request, $event));

        if ($oldDate !== $event->event_date->toDateString()) {
            $this->notifyParticipants($event, 'Event rescheduled', 'The event date or time has changed. Please review the updated event details.');
        } else {
            $this->notifyParticipants($event, 'Event details updated', 'The details for this event have been updated by the organizer.');
        }

        return redirect()->route('organizer.events.show', $event)->with('success', 'Event updated and participants notified.');
    }

    public function cancel(Event $event)
    {
        $this->authorizeEvent($event);
        abort_if($event->event_date->isPast(), 403, 'Past events cannot be cancelled.');

        $event->update(['status' => 'cancelled']);
        $this->notifyParticipants($event, 'Event cancelled', 'This event has been cancelled by the organizer.');

        return back()->with('success', 'Event cancelled and participants notified.');
    }

    private function validatedData(Request $request, ?Event $event = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time' => ['required', 'date_format:H:i'],
            'max_participants' => ['required', 'integer', 'min:1'],
            'waitlist_enabled' => ['nullable', 'boolean'],
            'cancellation_allowed' => ['nullable', 'boolean'],
            'cancellation_cutoff' => ['nullable', 'date', 'before_or_equal:event_date'],
            'certificate_fee' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'rulebook' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        foreach (['banner_image' => 'events', 'rulebook' => 'events'] as $field => $directory) {
            if ($request->hasFile($field)) {
                if ($event?->{$field}) {
                    Storage::disk('public')->delete($event->{$field});
                }
                $data[$field] = $request->file($field)->store($directory, 'public');
            }
        }

        $data['waitlist_enabled'] = $request->boolean('waitlist_enabled');
        $data['cancellation_allowed'] = $request->boolean('cancellation_allowed');
        $data['certificate_fee'] = $data['certificate_fee'] ?? 0;

        return $data;
    }

    private function notifyParticipants(Event $event, string $title, string $message): void
    {
        if ($event->registrations()->whereIn('status', ['confirmed', 'waitlist'])->exists()) {
            Announcement::create([
                'sent_by' => Auth::id(),
                'title' => $title,
                'message' => $message,
                'target_role' => 'participant',
                'event_id' => $event->event_id,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('sender', 'event')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $events = Event::approved()->orderByDesc('event_date')->get();

        return view('admin.announcements.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'message'     => 'required|string',
            'target_role' => 'required|in:all,participant,organizer',
            'event_id'    => 'nullable|exists:events,event_id',
        ]);

        Announcement::create([
            ...$validated,
            'sent_by' => auth()->id(),
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement sent.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Bookmark;
use App\Models\Event;
use App\Models\MediaGallery;
use App\Models\ContactMessage;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    public function home()
    {
        $announcements = Announcement::where('target_role', 'all')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $upcomingEvents = Event::approved()
            ->upcoming()
            ->orderBy('event_date')
            ->limit(6)
            ->get();

        return view('public.public_home', compact('announcements', 'upcomingEvents'));
    }

    public function events(Request $request)
    {
        $query = Event::approved()->with('organizer');

        $timing = $request->get('timing', 'upcoming');
        if ($timing === 'upcoming') {
            $query->upcoming();
        } elseif ($timing === 'past') {
            $query->past();
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $events = $query->orderBy('event_date')->paginate(9)->withQueryString();

        return view('public.events.public_events_index', compact('events'));
    }

    public function eventShow(Event $event)
    {
        abort_unless($event->status === 'approved', 404);

        $event->load(['organizer', 'seating', 'feedback' => fn ($query) => $query
            ->where('status', 'visible')->with('student')->latest('submitted_on')]);

        $isRegistered = Auth::check() && Auth::user()->isParticipant()
            && Registration::where('event_id', $event->event_id)
                ->where('student_id', Auth::id())
                ->whereIn('status', ['confirmed', 'waitlist'])
                ->exists();
        $bookmark = Auth::check() && Auth::user()->isParticipant()
            ? Bookmark::where('event_id', $event->event_id)->where('user_id', Auth::id())->first()
            : null;

        return view('public.events.public_events_show', compact('event', 'isRegistered', 'bookmark'));
    }

    public function gallery(Request $request)
    {
        $query = MediaGallery::where('status', 'visible')->with('event');

        // Note: category filter here maps loosely to event category for simplicity
        if ($request->filled('category')) {
            $query->whereHas('event', fn ($q) => $q->where('category', $request->category));
        }

        $media = $query->orderByDesc('uploaded_on')->paginate(12)->withQueryString();

        return view('public.public_gallery', compact('media'));
    }

    public function about()
    {
        return view('public.public_about');
    }

    public function contact()
    {
        return view('public.public_contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Persist message to database
        ContactMessage::create($request->only('name', 'email', 'subject', 'message'));

        // Log stub representing sending of mail notification
        Log::info("Contact inquiry received from {$request->email}: [{$request->subject}] {$request->message}");

        return back()->with('success', 'Thanks for reaching out — we\'ll get back to you soon.');
    }

    public function faq()
    {
        return view('public.public_faq');
    }

    public function sitemap()
    {
        return view('public.public_sitemap');
    }
}

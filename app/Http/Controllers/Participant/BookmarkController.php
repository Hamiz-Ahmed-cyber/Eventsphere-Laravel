<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('event')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('participant.bookmarks.index', compact('bookmarks'));
    }

    public function store(Event $event)
    {
        abort_unless($event->event_date->isFuture() || $event->event_date->isToday(), 403, 'Only upcoming events can be bookmarked.');

        Bookmark::firstOrCreate(['user_id' => Auth::id(), 'event_id' => $event->event_id]);

        return back()->with('success', 'Event bookmarked.');
    }

    public function destroy(Bookmark $bookmark)
    {
        abort_unless($bookmark->user_id === Auth::id(), 403);
        $bookmark->delete();

        return back()->with('success', 'Bookmark removed.');
    }
}

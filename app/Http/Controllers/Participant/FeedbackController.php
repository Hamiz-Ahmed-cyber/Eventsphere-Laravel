<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create(Event $event)
    {
        abort_unless(Attendance::where('event_id', $event->event_id)
            ->where('student_id', Auth::id())->where('attended', true)->exists(), 403);

        return view('participant.feedback.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        abort_unless(Attendance::where('event_id', $event->event_id)
            ->where('student_id', Auth::id())->where('attended', true)->exists(), 403);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'organizational_quality' => 'required|integer|min:1|max:5',
            'content_relevance' => 'required|integer|min:1|max:5',
            'venue_rating' => 'required|integer|min:1|max:5',
            'coordination_rating' => 'required|integer|min:1|max:5',
            'technical_arrangements' => 'required|integer|min:1|max:5',
            'hospitality_rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        Feedback::updateOrCreate(
            ['event_id' => $event->event_id, 'student_id' => Auth::id()],
            [...$validated, 'status' => 'visible', 'submitted_on' => now()]
        );

        return redirect()->route('participant.dashboard')->with('success', 'Thanks for your feedback!');
    }
}

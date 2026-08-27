<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class DashboardController extends OrganizerController
{
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())
            ->withCount(['registrations as registration_count' => fn ($query) => $query->where('status', 'confirmed')])
            ->withAvg(['feedback as feedback_average' => fn ($query) => $query->where('status', 'visible')], 'rating')
            ->orderBy('event_date')
            ->get();

        $stats = [
            'total_events' => $events->count(),
            'upcoming_events' => $events->where('event_date', '>=', now()->toDateString())->where('status', '!=', 'cancelled')->count(),
            'pending_events' => $events->where('status', 'pending')->count(),
            'registrations' => $events->sum('registration_count'),
            'average_rating' => round(Feedback::whereIn('event_id', $events->pluck('event_id'))->where('status', 'visible')->avg('rating') ?? 0, 2),
        ];

        return view('organizer.dashboard', compact('events', 'stats'));
    }
}

<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'registered_count'   => Registration::where('student_id', $userId)->where('status', '!=', 'cancelled')->count(),
            'attended_count'     => \App\Models\Attendance::where('student_id', $userId)->where('attended', true)->count(),
            'certificate_count'  => Certificate::where('student_id', $userId)->count(),
            'bookmark_count'     => Auth::user()->bookmarks()->count(),
        ];

        $upcomingRegistrations = Registration::with('event')
            ->where('student_id', $userId)
            ->where('status', '!=', 'cancelled')
            ->whereHas('event', fn ($q) => $q->where('event_date', '>=', now()->toDateString()))
            ->orderBy('registered_on')
            ->limit(5)
            ->get();

        $announcements = Announcement::whereIn('target_role', ['all', 'participant'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('participant.dashboard', compact('stats', 'upcomingRegistrations', 'announcements'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_participants' => User::where('role', 'participant')->count(),
            'total_organizers'   => User::where('role', 'organizer')->count(),
            'events_approved'    => Event::where('status', 'approved')->count(),
            'events_pending'     => Event::where('status', 'pending')->count(),
            'events_total'       => Event::count(),
            'avg_feedback_rating'=> round(Feedback::where('status', 'visible')->avg('rating') ?? 0, 2),
        ];

        // Top-performing departments = departments with the most registrations
        $topDepartments = User::join('user_details', 'users.id', '=', 'user_details.user_id')
            ->join('registrations', 'users.id', '=', 'registrations.student_id')
            ->select('user_details.department')
            ->selectRaw('count(*) as registration_count')
            ->whereNotNull('user_details.department')
            ->groupBy('user_details.department')
            ->orderByDesc('registration_count')
            ->limit(5)
            ->get();

        $recentEvents = Event::with('organizer')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'topDepartments', 'recentEvents'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Registration;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; // composer require barryvdh/laravel-dompdf

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    // Participation report: event_id, title, registrations, attendance %, avg rating
    public function participation(string $format = 'pdf')
    {
        $data = Event::withCount('registrations')
            ->with(['attendance', 'feedback'])
            ->orderByDesc('event_date')
            ->get()
            ->map(function ($event) {
                $attended = $event->attendance->where('attended', true)->count();
                return [
                    'title'          => $event->title,
                    'date'           => $event->event_date->format('d M Y'),
                    'registrations'  => $event->registrations_count,
                    'attended'       => $attended,
                    'avg_rating'     => round($event->feedback->avg('rating') ?? 0, 1),
                ];
            });

        if ($format === 'excel') {
            // composer require maatwebsite/excel
            // return Excel::download(new ParticipationExport($data), 'participation-report.xlsx');
            abort(501, 'Wire up maatwebsite/excel ParticipationExport class, then enable this line.');
        }

        $pdf = Pdf::loadView('admin.reports.participation-pdf', ['rows' => $data]);
        return $pdf->download('participation-report.pdf');
    }

    // User growth report: signups per role, per month
    public function userGrowth()
    {
        $growth = User::selectRaw('role, DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('role', 'month')
            ->orderBy('month')
            ->get();

        $pdf = Pdf::loadView('admin.reports.user-growth-pdf', ['rows' => $growth]);
        return $pdf->download('user-growth-report.pdf');
    }
}

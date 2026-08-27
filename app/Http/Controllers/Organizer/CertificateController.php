<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Certificate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CertificateController extends OrganizerController
{
    public function index(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load(['registrations.student.details', 'attendance', 'certificates.student']);
        $attendedIds = $event->attendance->where('attended', true)->pluck('student_id');
        $paidIds = $event->certificates->where('fee_paid', true)->pluck('student_id');
        $eligibleIds = $event->certificate_fee == 0 ? $attendedIds : $attendedIds->intersect($paidIds);
        $eligibleAttendees = $event->registrations
            ->whereIn('student_id', $eligibleIds)
            ->where('status', 'confirmed')
            ->values();

        return view('organizer.certificates.index', compact('event', 'eligibleAttendees'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $data = $request->validate([
            'certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['integer', 'distinct', 'exists:users,id'],
        ]);

        $attendedIds = $event->attendance()->where('attended', true)->pluck('student_id');
        $paidIds = $event->certificates()->where('fee_paid', true)->pluck('student_id');
        $eligibleIds = $event->certificate_fee == 0 ? $attendedIds : $attendedIds->intersect($paidIds);
        $selectedIds = collect($data['student_ids']);

        if ($selectedIds->diff($eligibleIds)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'student_ids' => 'Certificates can only be issued to eligible attendees.',
            ]);
        }

        $path = $request->file('certificate')->store('certificates', 'public');

        foreach ($selectedIds as $studentId) {
            Certificate::updateOrCreate(
                ['event_id' => $event->event_id, 'student_id' => $studentId],
                ['certificate_url' => $path, 'issued_on' => now()]
            );
        }

        return back()->with('success', $selectedIds->count().' certificate(s) issued.');
    }
}

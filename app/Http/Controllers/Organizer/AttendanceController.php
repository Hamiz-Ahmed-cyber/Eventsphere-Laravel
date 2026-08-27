<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends OrganizerController
{
    public function scan()
    {
        $events = Event::where('organizer_id', Auth::id())->whereDate('event_date', now())->orderBy('event_time')->get();
        return view('organizer.attendance.scan', compact('events'));
    }

    public function checkin(Request $request)
    {
        $data = $request->validate(['qr_code' => ['required', 'string', 'max:255']]);
        $registration = Registration::with(['event', 'student'])->where('qr_code', $data['qr_code'])->first();

        if (! $registration || $registration->status !== 'confirmed') {
            return response()->json(['message' => 'Valid confirmed registration not found.'], 404);
        }
        $this->authorizeEvent($registration->event);

        Attendance::updateOrCreate(
            ['event_id' => $registration->event_id, 'student_id' => $registration->student_id],
            ['attended' => true, 'marked_on' => now()]
        );

        return response()->json(['message' => 'Check-in recorded.', 'participant' => $registration->student?->name]);
    }

    public function report(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load(['registrations.student.details', 'attendance']);
        $attended = $event->attendance->where('attended', true)->pluck('student_id');
        return view('organizer.attendance.report', compact('event', 'attended'));
    }
}

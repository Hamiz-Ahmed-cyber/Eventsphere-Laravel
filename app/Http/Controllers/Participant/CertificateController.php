<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('event')
            ->where('student_id', Auth::id())
            ->orderByDesc('issued_on')
            ->paginate(10);

        return view('participant.certificates.index', compact('certificates'));
    }

    public function pay(Certificate $certificate)
    {
        abort_unless($certificate->student_id === Auth::id(), 403);

        // Payment gateway is explicitly out of scope per SRS — this just flips the stub flag.
        $certificate->update(['fee_paid' => true]);

        return back()->with('success', 'Fee marked as paid. You can now download your certificate.');
    }
}

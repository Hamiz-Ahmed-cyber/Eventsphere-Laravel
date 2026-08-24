<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\MediaGallery;

class ModerationController extends Controller
{
    public function feedback()
    {
        $feedback = Feedback::with('event', 'student')
            ->orderByDesc('submitted_on')
            ->paginate(15);

        return view('admin.moderation.feedback', compact('feedback'));
    }

    public function updateFeedbackStatus(Feedback $feedback, string $status)
    {
        abort_unless(in_array($status, ['visible', 'flagged', 'removed']), 400);

        $feedback->update(['status' => $status]);

        return back()->with('success', 'Feedback status updated.');
    }

    public function gallery()
    {
        $media = MediaGallery::with('event', 'uploader')
            ->orderByDesc('uploaded_on')
            ->paginate(20);

        return view('admin.moderation.gallery', compact('media'));
    }

    public function updateMediaStatus(MediaGallery $media, string $status)
    {
        abort_unless(in_array($status, ['visible', 'flagged', 'removed']), 400);

        $media->update(['status' => $status]);

        return back()->with('success', 'Media status updated.');
    }
}

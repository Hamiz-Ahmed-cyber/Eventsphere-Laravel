<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends OrganizerController
{
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())->with('media')->orderByDesc('event_date')->get();
        return view('organizer.media.index', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,event_id'],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,webm', 'max:51200'],
            'caption' => ['nullable', 'string', 'max:150'],
        ]);
        $event = Event::findOrFail($data['event_id']);
        $this->authorizeEvent($event);
        $file = $request->file('file');
        $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';

        MediaGallery::create([
            'event_id' => $event->event_id,
            'file_type' => $type,
            'file_url' => $file->store('gallery', 'public'),
            'uploaded_by' => Auth::id(),
            'caption' => $data['caption'] ?? null,
            'status' => 'visible',
            'uploaded_on' => now(),
        ]);

        return back()->with('success', 'Media uploaded.');
    }

    public function destroy(MediaGallery $media)
    {
        $media->load('event');
        $this->authorizeEvent($media->event);
        Storage::disk('public')->delete($media->file_url);
        $media->delete();
        return back()->with('success', 'Media deleted.');
    }
}

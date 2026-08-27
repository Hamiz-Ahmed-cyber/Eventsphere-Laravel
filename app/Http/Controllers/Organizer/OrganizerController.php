<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

abstract class OrganizerController extends Controller
{
    protected function organizerId(): int
    {
        return (int) Auth::id();
    }

    protected function authorizeEvent(Event $event): void
    {
        abort_unless((int) $event->organizer_id === $this->organizerId(), 403);
    }
}

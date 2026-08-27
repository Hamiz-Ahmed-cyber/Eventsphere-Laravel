<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderByDesc('created_at')->paginate(10);
        
        // Mark all fetched messages as read for simplicity
        ContactMessage::where('status', 'unread')->update(['status' => 'read']);

        return view('admin.contacts.index', compact('messages'));
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return back()->with('success', 'Message deleted successfully.');
    }
}

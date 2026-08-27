<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load('details');

        return view('participant.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:15',
            'department' => 'nullable|string|max:100',
            'enrollment_no' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...(isset($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'mobile' => $validated['mobile'] ?? null,
                'department' => $validated['department'] ?? null,
                'enrollment_no' => $validated['enrollment_no'] ?? null,
            ]
        );

        return back()->with('success', 'Profile updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Explicit role-based redirect — deliberately ignores any "intended"
        // URL Laravel may have stored (e.g. from visiting /admin while logged out),
        // so a participant never lands on the admin panel or vice versa.
        return redirect()->to($this->redirectPathForRole(Auth::user()->role));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Map a user's role to their panel's home route.
     */
    protected function redirectPathForRole(string $role): string
    {
        return match ($role) {
            'admin'       => route('admin.dashboard'),
            'organizer'   => route('organizer.dashboard'),
            'participant' => route('participant.dashboard'),
            default       => route('home'),
        };
    }
}

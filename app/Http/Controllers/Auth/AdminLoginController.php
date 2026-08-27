<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function create(): View
    {
        return view('auth.admin_login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (Auth::user()->role !== 'admin') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => __('Unauthorized access to Admin Portal.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }
}

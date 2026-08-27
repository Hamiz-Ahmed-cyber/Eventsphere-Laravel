<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Forgot Password · EventSphere</title>
    @vite('resources/css/app.css')
</head>
<body data-panel="public" class="min-h-screen flex items-center justify-center px-5 py-12">
    <main class="w-full max-w-md">
        <div class="card-glow">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block mb-5">
                    <span class="font-display text-2xl font-bold text-teal-700">EventSphere</span>
                </a>
                <h1 class="font-display text-2xl font-bold text-slate-900">Reset your password</h1>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">Enter your email address and we will send you a secure password reset link.</p>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-800">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com" class="w-full rounded-xl border border-teal-200 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 focus:outline-none">
                    @error('email')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn-primary w-full justify-center !bg-teal-600 hover:!bg-teal-700">Email Reset Link</button>
            </form>

            <div class="mt-6 pt-5 border-t border-teal-100 text-center text-sm">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 hover:underline">Back to login</a>
            </div>
        </div>
    </main>
</body>
</html>

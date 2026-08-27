<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Admin Login · EventSphere</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background: radial-gradient(circle at center, #1b1f38 0%, #080a10 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            overflow: hidden;
            position: relative;
        }
        /* Cosmic elements */
        .glow-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
        }
        .glow-1 {
            width: 500px;
            height: 500px;
            background: #ec4899;
            top: -10%;
            left: -10%;
        }
        .glow-2 {
            width: 600px;
            height: 600px;
            background: #8b5cf6;
            bottom: -20%;
            right: -10%;
        }
        .login-card {
            background: rgba(24, 28, 42, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(236, 72, 153, 0.2);
            box-shadow: 0 0 40px rgba(236, 72, 153, 0.1);
        }
        .input-glow:focus {
            border-color: #ec4899 !important;
            box-shadow: 0 0 15px rgba(236, 72, 153, 0.3) !important;
        }
    </style>
</head>
<body data-panel="admin" class="text-ink-50 antialiased p-4">

    <!-- Cosmic Glow Backgrounds -->
    <div class="glow-circle glow-1"></div>
    <div class="glow-circle glow-2"></div>

    <div class="w-full max-w-md login-card rounded-3xl p-8 z-10 relative">
        <!-- Logo / Title -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block mb-3">
                <span class="font-display text-2xl font-bold bg-gradient-to-r from-pink-500 to-violet-500 bg-clip-text text-transparent">
                    EventSphere
                </span>
            </a>
            <h1 class="font-display text-xl font-semibold tracking-tight">Admin Portal</h1>
            <p class="text-xs text-ink-300 mt-1.5">Sign in to control and moderate campus activities</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-pink-500/10 border border-pink-500/20 text-pink-400 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-medium text-ink-300 mb-1.5">Admin Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="w-full px-4 py-2.5 rounded-xl bg-base-900/80 border border-base-700 text-ink-50 text-sm placeholder:text-ink-500 input-glow focus:outline-none transition-all duration-200"
                       placeholder="Email address">
                @error('email')
                    <p class="text-xs text-rose-400 mt-1.5">⚠ {{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-medium text-ink-300 mb-1.5">Security Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full px-4 py-2.5 rounded-xl bg-base-900/80 border border-base-700 text-ink-50 text-sm placeholder:text-ink-500 input-glow focus:outline-none transition-all duration-200"
                       placeholder="••••••••">
                @error('password')
                    <p class="text-xs text-rose-400 mt-1.5">⚠ {{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-xs">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-base-700 bg-base-900 text-pink-600 focus:ring-pink-500 focus:ring-offset-base-950">
                    <span class="ms-2 text-ink-300">Remember session</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-pink-400 hover:text-pink-300 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-gradient-to-r from-pink-600 to-violet-600 hover:from-pink-500 hover:to-violet-500 text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-pink-950/40">
                    Access Console →
                </button>
            </div>
        </form>

        <!-- Back links -->
        <div class="mt-8 pt-6 border-t border-base-800 text-center text-xs">
            <span class="text-ink-500">Not an administrator?</span>
            <a href="{{ route('login') }}" class="text-cyan-400 hover:underline font-medium ms-1">
                Student Login Portal
            </a>
        </div>
    </div>

</body>
</html>

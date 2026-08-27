<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Create Account · EventSphere</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-color: #f8fafc;
            min-height: 100vh;
            font-family: 'Sora', sans-serif;
        }
        .accent-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #22c55e 100%);
        }
    </style>
</head>
<body class="text-slate-800 antialiased flex min-h-screen">

    <div class="flex-1 flex flex-col justify-center py-12 px-6 sm:px-12 lg:flex-none lg:w-[480px] bg-white border-r border-slate-100 z-10">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <!-- Branding -->
            <div class="mb-6">
                <a href="/" class="inline-block mb-3">
                    <span class="font-display text-2xl font-bold bg-gradient-to-r from-indigo-600 to-green-500 bg-clip-text text-transparent">
                        EventSphere
                    </span>
                </a>
                <h1 class="font-display text-2xl font-bold tracking-tight text-slate-900">Join EventSphere</h1>
                <p class="text-xs text-slate-500 mt-1.5">Create your student account to discover and attend events</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-600 mb-1.5">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all"
                           placeholder="Name">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">Student Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all"
                           placeholder="Email">
                    @error('email')
                        <p class="text-xs text-rose-500 mt-1.5">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <!-- User Type -->
                <div>
                    <label for="role" class="block text-xs font-semibold text-slate-600 mb-1.5">User Type</label>
                    <select id="role" name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all">
                        <option value="">Select your user type</option>
                        <option value="participant" @selected(old('role') === 'participant')>Participant</option>
                        <option value="organizer" @selected(old('role') === 'organizer')>Organizer</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-rose-500 mt-1.5">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 mb-1.5">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-all"
                           placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="text-xs text-rose-500 mt-1.5">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-colors duration-150 shadow-sm shadow-indigo-100">
                        Create Account
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs">
                <span class="text-slate-500">Already registered?</span>
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold ms-1">
                    Sign In
                </a>
            </div>
        </div>
    </div>

    <!-- Side Illustration Panel -->
    <div class="hidden lg:block relative flex-1 accent-bg overflow-hidden">
        <div class="absolute inset-0 bg-black/10 z-10"></div>
        
        <!-- Abstract glowing vector lines -->
        <svg class="absolute inset-0 w-full h-full opacity-30" viewBox="0 0 100 100" preserveAspectRatio="none" fill="none">
            <path d="M-20,50 Q25,80 50,50 T120,50" stroke="white" stroke-width="0.5" />
            <path d="M-20,30 Q25,10 50,40 T120,30" stroke="white" stroke-width="0.3" />
            <path d="M-20,70 Q25,90 50,60 T120,70" stroke="white" stroke-width="0.4" />
        </svg>

        <div class="absolute inset-0 flex flex-col justify-between p-16 text-white z-20">
            <div class="flex items-center gap-2">
                <span class="text-lg font-bold tracking-wider font-display">EventSphere</span>
            </div>
            
            <div class="max-w-md">
                <h2 class="text-4xl font-display font-bold leading-tight">Start Your Event Journey Here.</h2>
                <p class="mt-4 text-slate-200 text-sm leading-relaxed">
                    By creating an account, you gain instant access to campus bookings, notifications, event schedules, and downloadable certificates of attendance.
                </p>
            </div>
            
            <div class="text-xs text-slate-300">
                &copy; {{ date('Y') }} EventSphere. TechWiz 6 Project.
            </div>
        </div>
    </div>

</body>
</html>

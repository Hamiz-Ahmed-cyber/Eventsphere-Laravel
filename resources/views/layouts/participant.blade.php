<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title', 'My Dashboard') · EventSphere</title>
    @vite('resources/css/app.css')
</head>
<body data-panel="participant" class="p-shell">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <div class="panel-sidebar-overlay" data-panel-close></div>
        <aside class="panel-sidebar w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="px-6 py-6 border-b border-slate-100">
                <div class="flex items-center justify-between"><a href="{{ route('participant.dashboard') }}" class="flex items-center gap-2">
                    <span class="font-display text-xl font-bold text-indigo-600">EventSphere</span>
                </a><button type="button" class="panel-sidebar-close" data-panel-close aria-label="Close navigation">×</button></div>
                <span class="text-xs uppercase tracking-widest text-green-500 font-semibold">Participant</span>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1">
                <a href="{{ route('participant.dashboard') }}"
                   class="p-sidebar-link {{ request()->routeIs('participant.dashboard') ? 'active' : '' }}">
                    ⌂ Dashboard
                </a>
                <a href="{{ route('participant.events.index') }}"
                   class="p-sidebar-link {{ request()->routeIs('participant.events.*') ? 'active' : '' }}">
                    ◈ Browse Events
                </a>
                <a href="{{ route('participant.registrations.index') }}"
                   class="p-sidebar-link {{ request()->routeIs('participant.registrations.*') ? 'active' : '' }}">
                    ◉ My Registrations
                </a>
                <a href="{{ route('participant.certificates.index') }}"
                   class="p-sidebar-link {{ request()->routeIs('participant.certificates.*') ? 'active' : '' }}">
                    ◆ Certificates
                </a>
                <a href="{{ route('participant.bookmarks.index') }}"
                   class="p-sidebar-link {{ request()->routeIs('participant.bookmarks.*') ? 'active' : '' }}">
                    ☆ Bookmarks
                </a>
                <a href="{{ route('participant.profile.edit') }}"
                   class="p-sidebar-link {{ request()->routeIs('participant.profile.*') ? 'active' : '' }}">
                    ⚙ Profile Settings
                </a>
            </nav>

            <div class="px-4 py-5 border-t border-slate-100">
                <a href="{{ route('home') }}" class="p-sidebar-link">← Back to Site</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-sidebar-link w-full text-left text-rose-500 hover:bg-rose-50 hover:text-rose-600">
                        ⏻ Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="flex-1">
            <header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4 flex items-center justify-between"><button type="button" class="panel-menu-toggle" data-panel-open aria-label="Open navigation">☰</button>
                <h1 class="font-display text-2xl font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500">{{ auth()->user()->name ?? 'Participant' }}</span>
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600 to-green-500 flex items-center justify-center font-display font-semibold text-sm text-white">
                        {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('.panel-sidebar');
            const overlay = document.querySelector('.panel-sidebar-overlay');
            const open = document.querySelector('[data-panel-open]');
            const close = () => { sidebar?.classList.remove('is-open'); overlay?.classList.remove('is-open'); };
            open?.addEventListener('click', () => { sidebar?.classList.add('is-open'); overlay?.classList.add('is-open'); });
            document.querySelectorAll('[data-panel-close]').forEach(button => button.addEventListener('click', close));
            sidebar?.querySelectorAll('a').forEach(link => link.addEventListener('click', close));
        });
    </script>
</body>
</html>

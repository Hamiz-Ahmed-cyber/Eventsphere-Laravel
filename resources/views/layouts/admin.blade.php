<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title', 'Admin') · EventSphere</title>
    @vite('resources/css/app.css')
</head>
<body data-panel="admin" class="min-h-screen">

    {{-- Gradient accent stripe --}}
    <div class="panel-accent h-1 w-full"></div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <div class="panel-sidebar-overlay" data-panel-close></div>
        <aside class="panel-sidebar w-64 bg-base-900/80 backdrop-blur-xl border-r border-base-700 flex flex-col">
            <div class="px-6 py-6 border-b border-base-700">
                <div class="flex items-center justify-between"><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span class="font-display text-xl font-bold bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">
                        EventSphere
                    </span>
                </a><button type="button" class="panel-sidebar-close" data-panel-close aria-label="Close navigation">×</button></div>
                <span class="text-xs uppercase tracking-widest text-pink-400 font-semibold">Admin Panel</span>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>⌂</span> Dashboard
                </a>
                <a href="{{ route('admin.events.pending') }}"
                   class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <span>◈</span> Event Approvals
                    @if(($pendingCount ?? 0) > 0)
                        <span class="ml-auto badge-pending">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span>◉</span> User Management
                </a>
                <a href="{{ route('admin.moderation.feedback') }}"
                   class="sidebar-link {{ request()->routeIs('admin.moderation.*') ? 'active' : '' }}">
                    <span>◇</span> Content Moderation
                </a>
                <a href="{{ route('admin.announcements.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <span>◆</span> Announcements
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <span>▤</span> Reports
                </a>
            </nav>

            <div class="px-4 py-5 border-t border-base-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-rose-400 hover:bg-rose-500/10 hover:text-rose-400">
                        <span>⏻</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1">
            <header class="bg-base-900/60 backdrop-blur-xl border-b border-base-700 px-4 sm:px-8 py-5 flex items-center justify-between"><button type="button" class="panel-menu-toggle" data-panel-open aria-label="Open navigation">☰</button>
                <h1 class="font-display text-2xl font-semibold text-ink-50">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-ink-300">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600 to-pink-500 flex items-center justify-center font-display font-semibold text-sm text-white">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-lime-400/10 border border-lime-400/30 text-lime-400 text-sm">
                        {{ session('success') }}
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

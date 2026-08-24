<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') · EventSphere</title>
    @vite('resources/css/app.css')
</head>
<body data-panel="admin" class="min-h-screen bg-parchment-50">

    {{-- Top accent stripe: pink for Admin panel --}}
    <div class="panel-accent h-1.5 w-full"></div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-maroon-100 flex flex-col">
            <div class="px-6 py-5 border-b border-maroon-100">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span class="font-display text-xl font-semibold text-maroon-500">EventSphere</span>
                </a>
                <span class="text-xs uppercase tracking-wide text-role-admin font-semibold">Admin Panel</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.events.pending') }}"
                   class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    Event Approvals
                    @if(($pendingCount ?? 0) > 0)
                        <span class="ml-auto badge-pending">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    User Management
                </a>
                <a href="{{ route('admin.moderation.feedback') }}"
                   class="sidebar-link {{ request()->routeIs('admin.moderation.*') ? 'active' : '' }}">
                    Content Moderation
                </a>
                <a href="{{ route('admin.announcements.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    Announcements
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    Reports
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-maroon-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-maroon-500">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1">
            <header class="bg-white border-b border-maroon-100 px-8 py-4 flex items-center justify-between">
                <h1 class="font-display text-2xl font-semibold text-ink-900">@yield('title', 'Dashboard')</h1>
                <span class="text-sm text-ink-700">{{ auth()->user()->name ?? 'Admin' }}</span>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>

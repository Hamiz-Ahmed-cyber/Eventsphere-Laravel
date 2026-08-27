<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title', 'Organizer') · EventSphere</title>
    @vite('resources/css/app.css')
</head>
<body data-panel="organizer" class="min-h-screen">
    <div class="panel-accent h-1 w-full"></div>
    <div class="flex min-h-screen">
        <aside class="w-64 bg-base-900/80 backdrop-blur-xl border-r border-base-700 flex flex-col">
            <div class="px-6 py-6 border-b border-base-700">
                <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-2">
                    <span class="font-display text-xl font-bold bg-gradient-to-r from-violet-400 to-amber-400 bg-clip-text text-transparent">EventSphere</span>
                </a>
                <span class="text-xs uppercase tracking-widest text-amber-400 font-semibold">Organizer Panel</span>
            </div>
            <nav class="flex-1 px-3 py-5 space-y-1">
                <a href="{{ route('organizer.dashboard') }}" class="sidebar-link {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}"><span>⌂</span> Dashboard</a>
                <a href="{{ route('organizer.events.index') }}" class="sidebar-link {{ request()->routeIs('organizer.events.*') ? 'active' : '' }}"><span>◈</span> My Events</a>
                <a href="{{ route('organizer.events.create') }}" class="sidebar-link {{ request()->routeIs('organizer.events.create') ? 'active' : '' }}"><span>＋</span> Create Event</a>
                <a href="{{ route('organizer.attendance.scan') }}" class="sidebar-link {{ request()->routeIs('organizer.attendance.*') ? 'active' : '' }}"><span>▣</span> Attendance</a>
                <a href="{{ route('organizer.media.index') }}" class="sidebar-link {{ request()->routeIs('organizer.media.*') ? 'active' : '' }}"><span>▧</span> Media Gallery</a>
            </nav>
            <div class="px-4 py-5 border-t border-base-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-rose-400 hover:bg-rose-500/10"><span>⏻</span> Log Out</button>
                </form>
            </div>
        </aside>
        <main class="flex-1">
            <header class="bg-base-900/60 backdrop-blur-xl border-b border-base-700 px-8 py-5 flex items-center justify-between">
                <h1 class="font-display text-2xl font-semibold text-ink-50">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center gap-3"><span class="text-sm text-ink-300">{{ auth()->user()->name }}</span><div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-600 to-amber-400 flex items-center justify-center font-display font-semibold text-sm text-base-950">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div></div>
            </header>
            <div class="p-8">
                @if(session('success'))<div class="mb-6 px-4 py-3 rounded-xl bg-lime-400/10 border border-lime-400/30 text-lime-400 text-sm">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="mb-6 px-4 py-3 rounded-xl bg-rose-400/10 border border-rose-400/30 text-rose-400 text-sm">{{ session('error') }}</div>@endif
                @if($errors->any())<div class="mb-6 px-4 py-3 rounded-xl bg-rose-400/10 border border-rose-400/30 text-rose-400 text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>

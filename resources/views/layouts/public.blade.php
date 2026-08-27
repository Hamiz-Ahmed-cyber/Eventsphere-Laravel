<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title', 'EventSphere') · Discover Campus Events</title>
    <meta name="description" content="@yield('meta_description', 'EventSphere — your college event information system. Discover, register, and relive campus events.')">
    @vite('resources/css/app.css')
</head>
<body data-panel="public" class="min-h-screen overflow-x-hidden">

    <div class="public-3d-scene" aria-hidden="true">
        <div class="public-orbit public-orbit-one"></div>
        <div class="public-orbit public-orbit-two"></div>
        <div class="public-cube">
            <span></span><span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>

    <div class="panel-accent h-1 w-full fixed top-0 left-0 z-50"></div>

    {{-- ============ NAVBAR ============ --}}
    <header class="fixed top-1 left-0 right-0 z-40 backdrop-blur-xl bg-base-950/70 border-b border-base-700/60">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="public-brand flex items-center gap-2 group">
                <img src="{{ asset('favicon.svg') }}" alt="EventSphere logo" class="w-8 h-8 rounded-lg">
                <span class="font-display text-xl font-bold bg-gradient-to-r from-indigo-500 to-coral-500 bg-clip-text text-transparent
                             group-hover:from-coral-500 group-hover:to-indigo-500 transition-all duration-500">
                    EventSphere
                </span>
            </a>

            <button type="button" class="public-menu-toggle" aria-expanded="false" aria-controls="public-navigation" aria-label="Open navigation">☰</button>

            <div id="public-navigation" class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">Home</a>
                <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'nav-link-active' : '' }}">Events</a>
                <a href="{{ route('gallery.index') }}" class="nav-link {{ request()->routeIs('gallery.*') ? 'nav-link-active' : '' }}">Gallery</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">Contact</a>
                <a href="{{ route('faq') }}" class="nav-link {{ request()->routeIs('faq') ? 'nav-link-active' : '' }}">FAQ</a>
            </div>

            <div class="public-account flex items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'organizer' ? route('dashboard') : route('participant.dashboard')) }}"
                       class="btn-outline !py-1.5 !px-4 text-xs">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-ink-300 hover:text-ink-50 transition-colors">Log In</a>
                    <a href="{{ route('register') }}" class="btn-primary !py-1.5 !px-4 text-xs">Sign Up</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="pt-24">
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="mt-24 border-t border-base-700/60 bg-base-950/60">
        <div class="max-w-7xl mx-auto px-6 py-14 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('favicon.svg') }}" alt="EventSphere logo" class="w-8 h-8 rounded-lg">
                    <span class="font-display text-lg font-bold bg-gradient-to-r from-indigo-500 to-coral-500 bg-clip-text text-transparent">
                        EventSphere
                    </span>
                </div>
                <p class="text-sm text-ink-300 mt-3 leading-relaxed">
                    Discover, register, and relive every event happening across campus — all in one place.
                </p>
            </div>

            <div>
                <h4 class="font-display font-semibold text-ink-50 mb-3 text-sm">Explore</h4>
                <ul class="space-y-2 text-sm text-ink-300">
                    <li><a href="{{ route('events.index') }}" class="hover:text-coral-500 transition-colors">All Events</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="hover:text-coral-500 transition-colors">Media Gallery</a></li>
                    <li><a href="{{ route('sitemap') }}" class="hover:text-coral-500 transition-colors">Sitemap</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-display font-semibold text-ink-50 mb-3 text-sm">Support</h4>
                <ul class="space-y-2 text-sm text-ink-300">
                    <li><a href="{{ route('about') }}" class="hover:text-coral-500 transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-coral-500 transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-coral-500 transition-colors">FAQs</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-display font-semibold text-ink-50 mb-3 text-sm">Account</h4>
                <ul class="space-y-2 text-sm text-ink-300">
                    <li><a href="{{ route('login') }}" class="hover:text-coral-500 transition-colors">Log In</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-coral-500 transition-colors">Create Account</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-base-700/60 py-5 text-center text-xs text-ink-500">
            &copy; {{ date('Y') }} EventSphere. Built for TechWiz 6.
        </div>
    </footer>

    {{-- ============ Scroll-reveal animation engine ============ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const revealEls = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => entry.target.classList.add('reveal-visible'), i * 60);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            revealEls.forEach(el => observer.observe(el));

            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.querySelectorAll('.tilt-card').forEach((card) => {
                    card.addEventListener('pointermove', (event) => {
                        const bounds = card.getBoundingClientRect();
                        const x = (event.clientX - bounds.left) / bounds.width - 0.5;
                        const y = (event.clientY - bounds.top) / bounds.height - 0.5;
                        card.style.setProperty('--tilt-x', `${-y * 8}deg`);
                        card.style.setProperty('--tilt-y', `${x * 8}deg`);
                        card.style.setProperty('--tilt-lift', '-8px');
                    });
                    card.addEventListener('pointerleave', () => {
                        card.style.setProperty('--tilt-x', '0deg');
                        card.style.setProperty('--tilt-y', '0deg');
                        card.style.setProperty('--tilt-lift', '0px');
                    });
                });
            }
        });
    </script>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('.public-menu-toggle');
            const navigation = document.getElementById('public-navigation');
            if (!toggle || !navigation) return;
            toggle.addEventListener('click', () => {
                const open = navigation.classList.toggle('public-navigation-open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });
    </script>
</body>
</html>

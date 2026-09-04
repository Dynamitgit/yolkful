<nav x-data="{ open: false }" class="pm-nav" aria-label="Primary navigation">

    {{-- Floating Navbar --}}
    <div class="pm-nav-pill">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="pm-logo" aria-label="Protein Morning home">
            <img src="{{ asset('images/protein-morning-logo.png') }}" alt="">
            <span class="pm-wordmark">
                <strong>PROTEIN</strong>
                <em>MORNING</em>
            </span>
        </a>

        <span class="pm-brand-divider" aria-hidden="true"></span>

        {{-- Desktop Navigation --}}
        <div class="pm-nav-links">

            {{-- HOME --}}
            <a
                href="{{ url('/') }}"
                class="pm-nav-link pm-home {{ request()->is('/') ? 'pm-active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3.5 10.7 12 3.8l8.5 6.9v8.5a1 1 0 0 1-1 1h-5v-5.2h-5v5.2h-5a1 1 0 0 1-1-1z"/>
                </svg>
                <span>Home</span>
            </a>

            {{-- RECIPES --}}
            <a
                href="{{ route('posts.index') }}"
                class="pm-nav-link {{ request()->routeIs('posts.index') ? 'pm-active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 9.5h14l-1.2 7.1a2 2 0 0 1-2 1.7H8.2a2 2 0 0 1-2-1.7z"/>
                    <path d="M8 9.5c.2-2 1.7-3.2 4-3.2s3.8 1.2 4 3.2"/>
                    <path d="M9 13.2h.1"/>
                    <path d="M12 13.2h.1"/>
                    <path d="M15 13.2h.1"/>
                </svg>
                <span>Recipes</span>
            </a>

            {{-- 30G PROTEIN --}}
            <a
                href="{{ route('landing-pages.show', '30g-protein-breakfast') }}"
                class="pm-nav-link"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="9" y="3.5" width="6" height="3.5" rx="1"/>
                    <path d="M8 7h8a1 1 0 0 1 1 1v10a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V8a1 1 0 0 1 1-1z"/>
                    <path d="M7.5 13.5h9"/>
                </svg>
                <span>30G Protein</span>
            </a>

            {{-- QUICK & EASY --}}
            <a
                href="{{ route('landing-pages.show', 'easy-protein-breakfast') }}"
                class="pm-nav-link"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m13.2 3.8-6 8h5.1l-1.5 8.4 6-9h-5z"/>
                </svg>
                <span>Quick &amp; Easy</span>
            </a>

            {{-- ABOUT --}}
            <a
                href="{{ route('about') }}"
                class="pm-nav-link {{ request()->routeIs('about') ? 'pm-active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 10v6"/>
                    <path d="M12 7h.01"/>
                </svg>
                <span>About</span>
            </a>

        </div>

        {{-- Search --}}
        <a
            href="{{ route('posts.index') }}"
            class="pm-search"
            aria-label="Search recipes"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="10.8" cy="10.8" r="6.2"/>
                <path d="m15.4 15.4 4.1 4.1"/>
            </svg>
            <span>Search</span>
        </a>

        {{-- Mobile Menu Button --}}
        <button
            @click="open = !open"
            class="pm-menu"
            type="button"
            :aria-expanded="open.toString()"
            aria-controls="pm-mobile-menu"
            aria-label="Toggle navigation"
        >
            <span class="pm-menu-icon" aria-hidden="true">
                <i></i>
                <i></i>
                <i></i>
            </span>
            <span>Menu</span>
        </button>

    </div>

    {{-- Mobile Navigation --}}
    <div
        id="pm-mobile-menu"
        x-show="open"
        x-cloak
        x-transition
        class="pm-mobile"
        @click.outside="open = false"
    >

        <p class="pm-mobile-title">Navigation</p>

        <a
            href="{{ url('/') }}"
            class="{{ request()->is('/') ? 'pm-active' : '' }}"
            @click="open = false"
        >
            Home
        </a>

        <a
            href="{{ route('posts.index') }}"
            @click="open = false"
        >
            Recipes
        </a>

        <a
            href="{{ route('landing-pages.show', '30g-protein-breakfast') }}"
            @click="open = false"
        >
            30G Protein
        </a>

        <a
            href="{{ route('landing-pages.show', 'easy-protein-breakfast') }}"
            @click="open = false"
        >
            Quick &amp; Easy
        </a>

        <a
            href="{{ route('about') }}"
            @click="open = false"
        >
            About
        </a>

        <a
            href="{{ route('posts.index') }}"
            @click="open = false"
        >
            Search
        </a>

        {{-- Account --}}
        @auth

            <p class="pm-mobile-title">Account</p>

            <a
                href="{{ route('dashboard') }}"
                @click="open = false"
            >
                Dashboard
            </a>

            <a
                href="{{ route('profile.edit') }}"
                @click="open = false"
            >
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit">
                    Log Out
                </button>
            </form>

        @else

            <p class="pm-mobile-title">Account</p>

            <a
                href="{{ route('login') }}"
                @click="open = false"
            >
                Sign in
            </a>

            <a
                href="{{ route('register') }}"
                @click="open = false"
            >
                Create an account
            </a>

        @endauth

    </div>

</nav>


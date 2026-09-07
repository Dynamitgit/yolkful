<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Yolkful')</title>

    <meta
        name="description"
        content="@yield('description', 'High-protein breakfast recipes for real mornings.')"
    >

    <meta property="og:title" content="@yield('title', 'Yolkful')">
<meta
    property="og:description"
    content="@yield('description', 'High-protein breakfast recipes for real mornings.')"
>
<meta property="og:type" content="website">
<meta property="og:image" content="{{ asset('images/yolkful-hero-breakfast.png') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="pm-page">

    {{-- =====================================================
         YOLKFUL FLOATING NAVBAR
    ====================================================== --}}

    <nav
        x-data="{ mobileOpen: false }"
        class="pm-nav"
        aria-label="Primary navigation"
    >

        <div class="pm-shell pm-nav-pill">

            {{-- LOGO --}}
            <a
                href="{{ url('/') }}"
                class="pm-logo"
                aria-label="Yolkful home"
            >
                <img
                    src="{{ asset('images/yolkful-icon.png') }}"
                    alt="Yolkful"
                >

              <span class="pm-wordmark pm-wordmark-single">
    <span class="pm-wordmark-yolk">Yolk</span><span class="pm-wordmark-ful">ful</span>
</span>
            </a>

            <span
                class="pm-brand-divider"
                aria-hidden="true"
            ></span>


            {{-- =================================================
                 DESKTOP NAVIGATION
            ================================================== --}}

            <div class="pm-nav-links">

                {{-- HOME --}}
                <a
                    href="{{ url('/') }}"
                    class="pm-nav-link pm-home home-nav {{ request()->is('/') ? 'pm-active active' : '' }}"
                >
                  <svg class="chef-hat-icon" viewBox="0 0 24 24" aria-hidden="true">
    <circle cx="12" cy="12" r="9" fill="currentColor" stroke="none"/>
    <path d="M8 9.3c.8-1.9 2.5-3 4.4-3.2"
        fill="none"
        stroke="#fffefb"
        stroke-width="1.6"
        stroke-linecap="round"/>
    <circle cx="7.4" cy="11.6" r="0.9" fill="#fffefb" stroke="none"/>
</svg>

                    <span>Home</span>
                </a>


               {{-- RECIPES --}}
                <a
                    href="{{ route('posts.index') }}"
                    class="pm-nav-link {{ request()->routeIs('posts.*') ? 'pm-active' : '' }}"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5z"/>
                        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5z"/>
                        <path d="M9 7.5h.01M9 10.5h.01M9 13.5h.01"/>
                    </svg>
                    <span>Recipes</span>
                </a>


          {{-- HIGH PROTEIN (placeholder - landing page not built yet) --}}
                <a
                    href="{{ route('landing-pages.show', ['landingPage' => 'high-protein']) }}"
                    class="pm-nav-link {{ request()->is('high-protein') ? 'pm-active' : '' }}"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 10v4"/>
                        <path d="M2.5 9v6"/>
                        <path d="M20 10v4"/>
                        <path d="M21.5 9v6"/>
                        <rect x="5" y="8" width="2.5" height="8" rx="1"/>
                        <rect x="16.5" y="8" width="2.5" height="8" rx="1"/>
                        <line x1="7.5" y1="12" x2="16.5" y2="12" stroke-width="2.4"/>
                    </svg>

                    <span>High Protein</span>
                </a>


                {{-- QUICK & EASY (placeholder - landing page not built yet) --}}
                <a
                   href="{{ route('landing-pages.show', ['landingPage' => 'quick-easy']) }}"
                   class="pm-nav-link {{ request()->is('quick-easy') ? 'pm-active' : '' }}"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m13.2 3.8-6 8h5.1l-1.5 8.4 6-9h-5z"/>
                    </svg>

                    <span>Quick &amp; Easy</span>
                </a>

                {{-- MEAL PREP --}}
                <a
                    href="{{ route('landing-pages.show', ['landingPage' => 'meal-prep']) }}"
                    class="pm-nav-link {{ request()->is('meal-prep') ? 'pm-active' : '' }}"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8 3h8v3H8z"/>
                        <path d="M7 6h10v13a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2z"/>
                        <path d="M7 13h10"/>
                    </svg>

                    <span>Meal Prep</span>
                </a>
                {{-- ABOUT --}}
                <a
                    href="{{ route('about') }}"
                    class="pm-nav-link {{ request()->routeIs('about') ? 'pm-active' : '' }}"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
    <circle cx="12" cy="12" r="9"/>
    <path d="M12 10.5v6"/>
    <circle cx="12" cy="7.5" r="0.6" fill="currentColor" stroke="none"/>
</svg>

                    <span>About</span>
                </a>

            </div>


            {{-- =================================================
                 SEARCH (inline expand + live suggestions)
            ================================================== --}}

            <div
                class="pm-search-inline"
                x-data="{
                    searchOpen: false,
                    query: '',
                    suggestions: [],
                    loading: false,
                    timer: null,
                    fetchSuggestions() {
                        clearTimeout(this.timer);
                        if (this.query.length < 2) {
                            this.suggestions = [];
                            return;
                        }
                        this.timer = setTimeout(() => {
                            this.loading = true;
                            fetch('{{ route('search.suggestions') }}?q=' + encodeURIComponent(this.query))
                                .then(res => res.json())
                                .then(data => {
                                    this.suggestions = data;
                                    this.loading = false;
                                });
                        }, 250);
                    },
                    highlight(title) {
                        const q = this.query.trim();
                        if (!q) return title;
                        const escaped = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        return title.replace(new RegExp('(' + escaped + ')', 'ig'), '<mark>$1</mark>');
                    }
                }"
                @keydown.escape.window="searchOpen = false; suggestions = []"
                @click.outside="searchOpen = false; suggestions = []"
            >
                <form
                    action="{{ route('posts.index') }}"
                    method="GET"
                    class="pm-search-inline-form"
                    :class="{ 'is-open': searchOpen }"
                >
                    <button
                        type="button"
                        class="pm-search-icon-btn"
                        aria-label="Search recipes"
                        :aria-expanded="searchOpen.toString()"
                        @click="searchOpen = !searchOpen; $nextTick(() => $refs.searchInput && $refs.searchInput.focus())"
                    >
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="10.8" cy="10.8" r="6.2"></circle>
                            <path d="m15.4 15.4 4.1 4.1"></path>
                        </svg>
                    </button>

                    <input
                        type="search"
                        name="q"
                        x-ref="searchInput"
                        x-show="searchOpen"
                        x-cloak
                        x-model="query"
                        @input="fetchSuggestions()"
                        autocomplete="off"
                        placeholder="Search recipes..."
                        aria-label="Search recipes"
                        class="pm-search-inline-input"
                    />
                </form>

                {{-- Suggestions dropdown --}}
                <div
                    class="pm-search-suggestions"
                    x-show="searchOpen && (suggestions.length > 0 || loading)"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-120"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <template x-if="loading">
                        <div class="pm-search-suggestion-loading">
                            <div class="pm-search-skeleton">
                                <div class="pm-search-skeleton-img"></div>
                                <div class="pm-search-skeleton-line" style="width: 70%"></div>
                            </div>
                            <div class="pm-search-skeleton">
                                <div class="pm-search-skeleton-img"></div>
                                <div class="pm-search-skeleton-line" style="width: 55%"></div>
                            </div>
                            <div class="pm-search-skeleton">
                                <div class="pm-search-skeleton-img"></div>
                                <div class="pm-search-skeleton-line" style="width: 62%"></div>
                            </div>
                        </div>
                    </template>

                    <template x-if="!loading">
                        <template x-for="item in suggestions" :key="item.id">
                            <a :href="item.url" class="pm-search-suggestion">
                                <img :src="item.image ?? '{{ asset('images/default-cover.jpg') }}'" alt="" class="pm-search-suggestion-img">
                                <span class="pm-search-suggestion-text" x-html="highlight(item.title)"></span>
                            </a>
                        </template>
                    </template>
                </div>
            </div>


            {{-- =================================================
                 PERSISTENT SEARCH BAR (MOBILE)
                 Always visible, no expand/collapse toggle
            ================================================== --}}

            <div
                class="pm-search-mobile"
                x-data="{
                    query: '',
                    suggestions: [],
                    loading: false,
                    timer: null,
                    fetchSuggestions() {
                        clearTimeout(this.timer);
                        if (this.query.length < 2) {
                            this.suggestions = [];
                            return;
                        }
                        this.timer = setTimeout(() => {
                            this.loading = true;
                            fetch('{{ route('search.suggestions') }}?q=' + encodeURIComponent(this.query))
                                .then(res => res.json())
                                .then(data => {
                                    this.suggestions = data;
                                    this.loading = false;
                                });
                        }, 250);
                    },
                    highlight(title) {
                        const q = this.query.trim();
                        if (!q) return title;
                        const escaped = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        return title.replace(new RegExp('(' + escaped + ')', 'ig'), '<mark>$1</mark>');
                    }
                }"
                @keydown.escape.window="suggestions = []"
                @click.outside="suggestions = []"
            >
                <form
                    action="{{ route('posts.index') }}"
                    method="GET"
                    class="pm-search-mobile-form"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="10.8" cy="10.8" r="6.2"></circle>
                        <path d="m15.4 15.4 4.1 4.1"></path>
                    </svg>

                    <input
                        type="search"
                        name="q"
                        x-model="query"
                        @input="fetchSuggestions()"
                        autocomplete="off"
                        placeholder="Search recipes..."
                        aria-label="Search recipes"
                        class="pm-search-mobile-input"
                    />
                </form>

                {{-- Suggestions dropdown --}}
                <div
                    class="pm-search-suggestions pm-search-suggestions-mobile"
                    x-show="suggestions.length > 0 || loading"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-120"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <template x-if="loading">
                        <div class="pm-search-suggestion-loading">
                            <div class="pm-search-skeleton">
                                <div class="pm-search-skeleton-img"></div>
                                <div class="pm-search-skeleton-line" style="width: 70%"></div>
                            </div>
                            <div class="pm-search-skeleton">
                                <div class="pm-search-skeleton-img"></div>
                                <div class="pm-search-skeleton-line" style="width: 55%"></div>
                            </div>
                            <div class="pm-search-skeleton">
                                <div class="pm-search-skeleton-img"></div>
                                <div class="pm-search-skeleton-line" style="width: 62%"></div>
                            </div>
                        </div>
                    </template>

                    <template x-if="!loading">
                        <template x-for="item in suggestions" :key="item.id">
                            <a :href="item.url" class="pm-search-suggestion">
                                <img :src="item.image ?? '{{ asset('images/default-cover.jpg') }}'" alt="" class="pm-search-suggestion-img">
                                <span class="pm-search-suggestion-text" x-html="highlight(item.title)"></span>
                            </a>
                        </template>
                    </template>
                </div>
            </div>


            {{-- =================================================
                 ACCOUNT (DESKTOP)
            ================================================== --}}

            <div class="pm-nav-account">
                @auth
                    <div class="pm-account-menu" x-data="{ open: false }" @click.outside="open = false">
                        <button
                            class="pm-account-btn"
                            @click="open = !open"
                            :aria-expanded="open.toString()"
                        >
                            <span class="pm-avatar">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="pm-account-name">{{ auth()->user()->name }}</span>
                        </button>

                        <div class="pm-account-dropdown" x-show="open" x-cloak x-transition>
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            <a href="{{ route('profile.edit') }}">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="pm-login-btn pm-login-solid">Sign in</a>
                @endauth
            </div>


            {{-- =================================================
                 MOBILE MENU BUTTON
            ================================================== --}}

            <button
                @click="mobileOpen = !mobileOpen"
                class="pm-menu"
                type="button"
                :aria-expanded="mobileOpen.toString()"
                aria-controls="pm-mobile-menu"
                aria-label="Toggle navigation"
            >
                <span
                    class="pm-menu-icon"
                    aria-hidden="true"
                >
                    <i></i>
                    <i></i>
                    <i></i>
                </span>

                <span>Menu</span>
            </button>

        </div>


        {{-- =====================================================
             MOBILE NAVIGATION
        ====================================================== --}}

        <div
            id="pm-mobile-menu"
            x-show="mobileOpen"
            x-cloak
            x-transition
            class="pm-mobile"
            @click.outside="mobileOpen = false"
        >

            <p class="pm-mobile-title">
                Navigation
            </p>


            {{-- HOME --}}
            <a
                href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'pm-active' : '' }}"
                @click="mobileOpen = false"
            >
                <span>Home</span>
            </a>


            {{-- RECIPES --}}
            <a
                href="{{ route('posts.index') }}"
                class="{{ request()->routeIs('posts.*') ? 'pm-active' : '' }}"
                @click="mobileOpen = false"
            >
                <span>Recipes</span>
            </a>


            {{-- HIGH PROTEIN (placeholder) --}}
            <a
            href="{{ route('landing-pages.show', ['landingPage' => 'high-protein']) }}"
            @click="mobileOpen = false"
          >
              <span>High Protein</span>
           </a>


            {{-- QUICK & EASY (placeholder) --}}
            <a
                href="{{ route('landing-pages.show', ['landingPage' => 'quick-easy']) }}"
                @click="mobileOpen = false"
            >
                <span>Quick &amp; Easy</span>
            </a>
            {{-- MEAL PREP --}}
            <a
                href="{{ route('landing-pages.show', ['landingPage' => 'meal-prep']) }}"
                @click="mobileOpen = false"
            >
                <span>Meal Prep</span>
            </a>

            {{-- ABOUT --}}
            <a
                href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'pm-active' : '' }}"
                @click="mobileOpen = false"
            >
                <span>About</span>
            </a>
           

        


            {{-- =================================================
                 ACCOUNT
            ================================================== --}}

            @auth

                <p class="pm-mobile-title">
                    Your account
                </p>

                <a
                    href="{{ route('dashboard') }}"
                    @click="mobileOpen = false"
                >
                    <span>Dashboard</span>
                </a>

                <a
                    href="{{ route('profile.edit') }}"
                    @click="mobileOpen = false"
                >
                    <span>Profile</span>
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button type="submit">
                        Sign out
                    </button>
                </form>

            @else

                <p class="pm-mobile-title">
                    Your account
                </p>

                <a
                    href="{{ route('login') }}"
                    @click="mobileOpen = false"
                >
                    <span>Sign in</span>
                </a>

                <a
                    href="{{ route('register') }}"
                    @click="mobileOpen = false"
                >
                    <span>Create an account</span>
                </a>

            @endauth

        </div>

    </nav>


    {{-- =====================================================
         PAGE CONTENT
    ====================================================== --}}

    <main>

        @if(session('success'))
            <div
                class="pm-shell"
                style="padding-top:20px"
            >
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')

    </main>

</body>
</html>
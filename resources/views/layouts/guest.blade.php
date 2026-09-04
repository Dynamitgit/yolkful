<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Protein Morning')
    </title>

    <meta
        name="description"
        content="@yield(
            'description',
            'High-protein breakfast recipes for real mornings.'
        )"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="pm-page pm-auth-page">

    <div class="pm-auth-wrapper">


        {{-- =====================================================
             AUTH HEADER
        ====================================================== --}}

        <header class="pm-auth-header">

            <a
                href="{{ url('/') }}"
                class="pm-auth-logo"
                aria-label="Protein Morning home"
            >

                <img
                    src="{{ asset('images/protein-morning-logo.png') }}"
                    alt="Protein Morning"
                >

                <span class="pm-auth-wordmark">

                    <strong>PROTEIN</strong>

                    <em>MORNING</em>

                </span>

            </a>


            <a
                href="{{ url('/') }}"
                class="pm-auth-home"
            >
                ← Home
            </a>

        </header>



        {{-- =====================================================
             AUTH CONTENT
        ====================================================== --}}

        <main class="pm-auth-main">

            <div class="pm-auth-card">

                @yield('content')

            </div>

        </main>



        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <footer class="pm-auth-footer">

            <p>
                © {{ date('Y') }} Protein Morning.
                All rights reserved.
            </p>

        </footer>

    </div>

</body>

</html>
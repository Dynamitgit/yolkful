@extends('layouts.guest')


@section('title', 'Sign In — Protein Morning')


@section('content')


    {{-- =====================================================
         TITLE
    ====================================================== --}}

    <h1 class="pm-auth-heading">

        Welcome <span>back.</span>

    </h1>


    <p class="pm-auth-subtitle">

        Sign in to save your favorite high-protein recipes
        and keep your morning routine on track.

    </p>



    {{-- =====================================================
         SESSION STATUS
    ====================================================== --}}

    @if (session('status'))

        <div class="pm-auth-session">

            {{ session('status') }}

        </div>

    @endif



    {{-- =====================================================
         LOGIN FORM
    ====================================================== --}}

    <form
        method="POST"
        action="{{ route('login') }}"
        class="pm-auth-form"
    >

        @csrf



        {{-- EMAIL --}}

        <div class="pm-auth-field">

            <label
                for="email"
                class="pm-auth-label"
            >
                Email
            </label>


            <input
                id="email"
                class="pm-auth-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
            >


            @if ($errors->get('email'))

                <p class="pm-auth-error">

                    {{ $errors->first('email') }}

                </p>

            @endif

        </div>



        {{-- PASSWORD --}}

        <div class="pm-auth-field">

            <label
                for="password"
                class="pm-auth-label"
            >
                Password
            </label>


            <input
                id="password"
                class="pm-auth-input"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Your password"
            >


            @if ($errors->get('password'))

                <p class="pm-auth-error">

                    {{ $errors->first('password') }}

                </p>

            @endif

        </div>



        {{-- =================================================
             REMEMBER + FORGOT PASSWORD
        ================================================== --}}

        <div class="pm-auth-options">


            <label
                for="remember_me"
                class="pm-auth-remember"
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                >

                <span>
                    Remember me
                </span>

            </label>



            @if (Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"
                    class="pm-auth-link"
                >
                    Forgot password?
                </a>

            @endif


        </div>



        {{-- =================================================
             SUBMIT
        ================================================== --}}

        <button
            type="submit"
            class="pm-auth-submit"
        >

            Sign in

        </button>

    </form>



    {{-- =====================================================
         REGISTER
    ====================================================== --}}

    @if (Route::has('register'))

        <p class="pm-auth-bottom">

            Don't have an account?

            <a href="{{ route('register') }}">
                Create one
            </a>

        </p>

    @endif


@endsection
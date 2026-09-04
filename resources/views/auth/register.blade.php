@extends('layouts.guest')


@section('title', 'Create Account — Protein Morning')


@section('content')


    {{-- =====================================================
         TITLE
    ====================================================== --}}

    <h1 class="pm-auth-heading">

        Start your <span>morning.</span>

    </h1>


    <p class="pm-auth-subtitle">

        Create your Protein Morning account and save
        your favorite high-protein recipes.

    </p>



    {{-- =====================================================
         REGISTER FORM
    ====================================================== --}}

    <form
        method="POST"
        action="{{ route('register') }}"
        class="pm-auth-form"
    >

        @csrf



        {{-- NAME --}}

        <div class="pm-auth-field">

            <label
                for="name"
                class="pm-auth-label"
            >
                Name
            </label>


            <input
                id="name"
                class="pm-auth-input"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Your name"
            >


            @if ($errors->get('name'))

                <p class="pm-auth-error">

                    {{ $errors->first('name') }}

                </p>

            @endif

        </div>



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
                autocomplete="new-password"
                placeholder="Create a password"
            >


            @if ($errors->get('password'))

                <p class="pm-auth-error">

                    {{ $errors->first('password') }}

                </p>

            @endif

        </div>



        {{-- CONFIRM PASSWORD --}}

        <div class="pm-auth-field">

            <label
                for="password_confirmation"
                class="pm-auth-label"
            >
                Confirm password
            </label>


            <input
                id="password_confirmation"
                class="pm-auth-input"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Repeat your password"
            >


            @if ($errors->get('password_confirmation'))

                <p class="pm-auth-error">

                    {{ $errors->first('password_confirmation') }}

                </p>

            @endif

        </div>



        {{-- SUBMIT --}}

        <button
            type="submit"
            class="pm-auth-submit"
        >

            Create account

        </button>

    </form>



    {{-- =====================================================
         LOGIN LINK
    ====================================================== --}}

    <p class="pm-auth-bottom">

        Already have an account?

        <a href="{{ route('login') }}">
            Sign in
        </a>

    </p>


@endsection
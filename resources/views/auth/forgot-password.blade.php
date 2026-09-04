@extends('layouts.guest')

@section('title', 'Forgot Password — Protein Morning')

@section('content')

    {{-- =====================================================
         TITLE
    ====================================================== --}}

    <h1 class="pm-auth-heading">
        Forgot your <span>password?</span>
    </h1>

    <p class="pm-auth-subtitle">
        No worries. Enter your email address and we'll send you
        a link to reset your password.
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
         PASSWORD RESET FORM
    ====================================================== --}}

    <form
        method="POST"
        action="{{ route('password.email') }}"
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
                autocomplete="email"
                placeholder="you@example.com"
            >

            @if ($errors->get('email'))

                <p class="pm-auth-error">
                    {{ $errors->first('email') }}
                </p>

            @endif

        </div>


        {{-- SUBMIT --}}

        <button
            type="submit"
            class="pm-auth-submit"
        >
            Send reset link
        </button>

    </form>


    {{-- =====================================================
         BACK TO LOGIN
    ====================================================== --}}

    <p class="pm-auth-bottom">

        Remember your password?

        <a href="{{ route('login') }}">
            Sign in
        </a>

    </p>

@endsection
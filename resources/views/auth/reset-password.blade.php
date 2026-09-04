@extends('layouts.guest')

@section('title', 'Reset Password — Protein Morning')

@section('content')

    <h1 class="pm-auth-heading">
        Reset your <span>password.</span>
    </h1>

    <p class="pm-auth-subtitle">
        Create a new password for your Protein Morning account.
    </p>

    <form
        method="POST"
        action="{{ route('password.store') }}"
        class="pm-auth-form"
    >

        @csrf

        {{-- Password Reset Token --}}
        <input
            type="hidden"
            name="token"
            value="{{ $request->route('token') }}"
        >

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
                value="{{ old('email', $request->email) }}"
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

        {{-- NEW PASSWORD --}}
        <div class="pm-auth-field">

            <label
                for="password"
                class="pm-auth-label"
            >
                New password
            </label>

            <input
                id="password"
                class="pm-auth-input"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Create a new password"
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
                placeholder="Repeat your new password"
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
            Reset password
        </button>

    </form>

    <p class="pm-auth-bottom">

        Remember your password?

        <a href="{{ route('login') }}">
            Sign in
        </a>

    </p>

@endsection
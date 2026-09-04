@extends('layouts.guest')

@section('title', 'Activate Your Account — Protein Morning')

@section('content')

    <div class="pm-auth-verify">

        {{-- ICON --}}

        <div class="pm-auth-verify-icon">
            ✉
        </div>


        {{-- TITLE --}}

        <h1 class="pm-auth-heading">
            Activate your <span>account.</span>
        </h1>


        {{-- DESCRIPTION --}}

        <p class="pm-auth-subtitle">
            Thanks for joining Protein Morning.
            Before you continue, please verify your email address
            by clicking the link we sent you.
        </p>


        {{-- SUCCESS MESSAGE --}}

        @if (session('status') === 'verification-link-sent')

            <div class="pm-auth-session">
                A new verification link has been sent to your email address.
            </div>

        @endif


        {{-- RESEND VERIFICATION --}}

        <form
            method="POST"
            action="{{ route('verification.send') }}"
            class="pm-auth-form"
        >

            @csrf

            <button
                type="submit"
                class="pm-auth-submit"
            >
                Resend verification email
            </button>

        </form>


        {{-- LOGOUT --}}

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="pm-auth-logout-form"
        >

            @csrf

            <button
                type="submit"
                class="pm-auth-logout"
            >
                Sign out
            </button>

        </form>

    </div>

@endsection
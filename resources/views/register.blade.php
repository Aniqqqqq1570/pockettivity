@extends('layout')

@section('title', 'Create Account | Pockettivity')

@section('content')

<section class="login-page">

    <div class="login-box">

        <a href="{{ route('home') }}" class="auth-brand">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <span>pockettivity</span>
        </a>

        <p class="small-title">START WITH A CLEARER PICTURE</p>

        <h2>
            Create your account
        </h2>

        <p>
            Build a simple habit of understanding your money.
        </p>

        @include('partials.ui-alerts', ['alertClass' => 'auth-message'])

        <form action="{{ route('register.store') }}" method="POST">

            @csrf

            <label>
                Your name
            </label>

            <input
                type="text"
                name="name"
                placeholder="Your name"
                value="{{ old('name') }}"
                required
            >

            <label>
                Your email address
            </label>

            <input
                type="email"
                name="email"
                placeholder="you@example.com"
                value="{{ old('email') }}"
                required
            >

            <label>
                Create a password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Create a password"
                required
            >

            <label>
                Confirm your password
            </label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm your password"
                required
            >

            <button type="submit">
                Create Account
            </button>

        </form>

        <p class="register-text">

            Already have an account?

            <a href="{{ route('login') }}">
                Log In
            </a>

        </p>

    </div>

</section>

@endsection
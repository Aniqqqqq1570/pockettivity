@extends('layout')

@section('title', 'Log In | Pockettivity')

@section('content')

<section class="login-page">

    <div class="login-box">

        <a href="{{ route('home') }}" class="auth-brand">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <span>pockettivity</span>
        </a>

        <p class="small-title">YOUR FINANCES, IN FOCUS</p>

        <h2>
            Welcome back
        </h2>

        <p>
            Sign in to your Pockettivity account.
        </p>

        @include('partials.ui-alerts', ['alertClass' => 'auth-message'])

        <form action="{{ route('login.process') }}" method="POST">

            @csrf

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
                Your password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit">
                Log In
            </button>

        </form>

        <p class="register-text">

            New to Pockettivity?

            <a href="{{ route('register') }}">
                Create an account
            </a>

        </p>

    </div>

</section>

@endsection
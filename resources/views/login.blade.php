@extends('layout')

@section('title', 'Login - Pockettivity')

@section('content')

<section class="login-page">

    <div class="login-box">

        <h2>
            Login
        </h2>

        <p>
            Masuk ke akun Pockettivity
        </p>

        @if(session('success'))

            <p style="color: green;">
                {{ session('success') }}
            </p>

        @endif

        @if($errors->any())

            <p style="color: red;">
                {{ $errors->first() }}
            </p>

        @endif

        <form action="{{ route('login.process') }}" method="POST">

            @csrf

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                value="{{ old('email') }}"
                required
            >

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button type="submit">
                Login
            </button>

        </form>

        <p class="register-text">

            Belum punya akun?

            <a href="{{ route('register') }}">
                Register
            </a>

        </p>

    </div>

</section>

@endsection
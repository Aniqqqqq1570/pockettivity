@extends('layout')

@section('title', 'Register - Pockettivity')

@section('content')

<section class="login-page">

    <div class="login-box">

        <h2>
            Register
        </h2>

        <p>
            Buat akun Pockettivity
        </p>

        @if($errors->any())

            <div style="color: red; margin-bottom: 15px;">

                @foreach($errors->all() as $error)

                    <p>
                        {{ $error }}
                    </p>

                @endforeach

            </div>

        @endif

        <form action="{{ route('register.store') }}" method="POST">

            @csrf

            <label>
                Nama
            </label>

            <input
                type="text"
                name="name"
                placeholder="Masukkan nama"
                value="{{ old('name') }}"
                required
            >

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

            <label>
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
            >

            <button type="submit">
                Register
            </button>

        </form>

        <p class="register-text">

            Sudah punya akun?

            <a href="{{ route('login') }}">
                Login
            </a>

        </p>

    </div>

</section>

@endsection
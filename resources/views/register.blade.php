@extends('layout')

@section('title', 'Buat Akun | Pockettivity')

@section('content')

<section class="login-page">

    <div class="login-box">

        <a href="{{ route('home') }}" class="auth-brand">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <span>pockettivity</span>
        </a>

        <p class="small-title">MULAI DENGAN GAMBARAN YANG JELAS</p>

        <h2>
            Buat akun Anda
        </h2>

        <p>
            Bangun kebiasaan sederhana untuk memahami keuangan Anda.
        </p>

        @include('partials.ui-alerts', ['alertClass' => 'auth-message'])

        <form action="{{ route('register.store') }}" method="POST">

            @csrf

            <label>
                Nama
            </label>

            <input
                type="text"
                name="name"
                placeholder="Nama Anda"
                value="{{ old('name') }}"
                required
            >

            <label>
                Alamat email
            </label>

            <input
                type="email"
                name="email"
                placeholder="nama@contoh.com"
                value="{{ old('email') }}"
                required
            >

            <label>
                Buat kata sandi
            </label>

            <input
                type="password"
                name="password"
                placeholder="Buat kata sandi"
                required
            >

            <label>
                Ulangi kata sandi
            </label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi kata sandi"
                required
            >

            <button type="submit">
                Buat Akun
            </button>

        </form>

        <p class="register-text">

            Sudah memiliki akun?

            <a href="{{ route('login') }}">Masuk</a>
            </a>

        </p>

    </div>

</section>

@endsection
@extends('layout')

@section('title', 'Masuk | Pockettivity')

@section('content')

<section class="login-page">

    <div class="login-box">

        <a href="{{ route('home') }}" class="auth-brand">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <span>pockettivity</span>
        </a>

        <p class="small-title">KEUANGAN ANDA, LEBIH TERARAH</p>

        <h2>
            Selamat datang kembali
        </h2>

        <p>
            Masuk ke akun Pockettivity Anda.
        </p>

        @include('partials.ui-alerts', ['alertClass' => 'auth-message'])

        <form action="{{ route('login.process') }}" method="POST">

            @csrf

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
                Kata sandi
            </label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan kata sandi"
                required
            >

            <button type="submit">
                Masuk
            </button>

        </form>

        <p class="register-text">

            Belum memiliki akun Pockettivity?

            <a href="{{ route('register') }}">
                Buat akun
            </a>

        </p>

    </div>

</section>

@endsection
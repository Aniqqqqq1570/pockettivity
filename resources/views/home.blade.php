@extends('layout')

@section('title', 'Pockettivity - Kelola Keuangan')

@section('content')

<section class="hero">

    <div class="hero-content">

        <p class="small-title">
            PERSONAL FINANCE
        </p>

        <h1>
            Kelola Keuangan
            <br>
            Jadi Lebih Mudah
        </h1>

        <p class="hero-text">
            Pockettivity membantu kamu mencatat pemasukan,
            pengeluaran, dan mengatur keuangan dengan lebih mudah.
        </p>

        <div class="hero-buttons">

            <a href="{{ route('login') }}" class="button primary">
                Mulai Sekarang
            </a>

            <a href="{{ route('features') }}" class="button secondary">
                Lihat Fitur
            </a>

        </div>

    </div>

</section>


<section class="start-section">

    <div>

        <h2>
            Siap mengatur keuanganmu?
        </h2>

        <p>
            Mulai catat keuanganmu bersama Pockettivity.
        </p>

        <a href="{{ route('login') }}" class="button primary">
            Mulai Sekarang
        </a>

    </div>

</section>

@endsection
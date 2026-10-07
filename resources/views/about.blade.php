@extends('layout')

@section('title', 'Tentang - Pockettivity')

@section('content')

<section class="about-page">

    <div class="about-container">

        <p class="small-title">
            TENTANG POCKETTIVITY
        </p>

        <h1>
            Kelola Keuangan Jadi Lebih Mudah
        </h1>

        <p>
            Pockettivity adalah aplikasi yang dibuat untuk membantu
            pengguna dalam mengelola keuangan pribadi.
        </p>

        <p>
            Dengan Pockettivity, pengguna dapat mencatat pemasukan,
            pengeluaran, mengatur budget, dan melihat kondisi
            keuangan dengan lebih mudah.
        </p>

        <div class="about-card">

            <h2>
                Tujuan Pockettivity
            </h2>

            <p>
                Membantu pengguna agar lebih mudah mencatat,
                mengatur, dan memahami kondisi keuangan mereka
                dalam satu aplikasi.
            </p>

        </div>

        <a href="{{ route('home') }}" class="button primary">
            Kembali ke Home
        </a>

    </div>

</section>

@endsection
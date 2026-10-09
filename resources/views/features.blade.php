@extends('layout')

@section('title', 'Fitur Pockettivity')

@section('content')

<section class="features-page">

    <div class="features-container">

        <p class="small-title">
            FITUR POCKETTIVITY
        </p>

        <h1>
            Perangkat untuk keuangan sehari-hari
        </h1>

        <p class="features-description">
            Tata catatan, pantau anggaran, dan pahami aktivitas keuangan Anda.
        </p>


        <div class="features-list">

            <a href="{{ route('transactions') }}" class="feature-card">

                <div class="icon">
                    +
                </div>

                <h3>
                    Pencatatan Transaksi
                </h3>

                <p>
                    Catat pemasukan dan pengeluaran dalam satu riwayat yang mudah dicari.
                </p>

            </a>


            <a href="{{ route('analysis') }}" class="feature-card">

                <div class="icon">
                    ↗
                </div>

                <h3>
                    Laporan &amp; Analisis
                </h3>

                <p>
                    Tinjau arus kas, aktivitas bulanan, dan pengeluaran per kategori.
                </p>

            </a>


            <a href="{{ route('categories') }}" class="feature-card">

                <div class="icon">
                    Rp
                </div>

                <h3>
                    Kategori
                </h3>

                <p>
                    Kelompokkan transaksi sesuai kebutuhan Anda.
                </p>

            </a>

            <a href="{{ route('budgets') }}" class="feature-card">
                <div class="icon">Rp</div>
                <h3>Pengelolaan Anggaran</h3>
                <p>Tetapkan batas pengeluaran bulanan per kategori dan pantau perkembangannya.</p>
            </a>

            <a href="{{ route('transactions') }}" class="feature-card">
                <div class="icon">≡</div>
                <h3>Riwayat Transaksi</h3>
                <p>Cari, filter, dan urutkan catatan keuangan Anda.</p>
            </a>

            <a href="{{ route('dashboard') }}" class="feature-card">
                <div class="icon">✓</div>
                <h3>Ringkasan Keuangan</h3>
                <p>Lihat pemasukan, pengeluaran, saldo, dan sisa anggaran sekilas.</p>
            </a>

        </div>


        <a href="{{ route('home') }}" class="button primary">
            Kembali ke Beranda
        </a>

    </div>

</section>

@endsection
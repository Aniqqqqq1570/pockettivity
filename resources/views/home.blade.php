@extends('layout')

@section('title', 'Pockettivity | Keuangan Lebih Jelas')

@section('content')

<section class="hero">

    <div class="hero-content">
        <div class="hero-copy">
            <p class="small-title">KEUANGAN PRIBADI LEBIH TERARAH</p>
            <h1>Kelola keuangan bersama <strong>pockettivity</strong></h1>
            <p class="hero-text">
                Cara sederhana untuk mencatat pemasukan, pengeluaran, dan target tabungan. Ambil keputusan keuangan sehari-hari dengan lebih yakin.
            </p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="button primary">Buka Dasbor</a>
                @else
                    <a href="{{ route('register') }}" class="button primary">Mulai</a>
                @endauth
                <a href="{{ route('features') }}" class="button secondary">Lihat Fitur</a>
            </div>
            <p class="hero-platform-note"><span></span> Ruang kerja keuangan pribadi Anda</p>
        </div>

        <div class="hero-visual" role="img" aria-label="Ruang kerja keuangan Pockettivity dengan fitur transaksi, anggaran, dan pengeluaran">
            <div class="app-showcase">
                <div class="app-showcase-top">
                    <span>Ruang kerja Pockettivity</span>
                    <span class="showcase-status">Siap digunakan</span>
                </div>
                <div class="app-showcase-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="">
                    <div>
                        <strong>pockettivity</strong>
                        <span>Keuangan pribadi lebih terarah</span>
                    </div>
                </div>
                <div class="showcase-points">
                    <div class="showcase-point">Catat setiap transaksi</div>
                    <div class="showcase-point">Rencanakan anggaran bulanan</div>
                    <div class="showcase-point">Pantau penggunaan uang</div>
                </div>
                <div class="app-showcase-footer">
                    <span>Ringkasan keuangan dalam satu tampilan</span>
                    <strong>POCKETTIVITY</strong>
                </div>
            </div>
        </div>

    </div>

</section>


<section class="features home-features">

    <div class="features-container">
        <p class="small-title">KEUANGAN LEBIH JELAS, SETIAP HARI</p>
        <h2>Keuangan Anda tertata dengan baik</h2>

        <div class="features-list">
            <a href="{{ route('transactions') }}" class="feature-card">
                <div class="icon">+</div>
                <h3>Pencatatan transaksi</h3>
                <p>Simpan pemasukan dan pengeluaran dalam riwayat yang mudah dicari.</p>
            </a>
            <a href="{{ route('analysis') }}" class="feature-card">
                <div class="icon">↗</div>
                <h3>Laporan dan analisis</h3>
                <p>Pahami aktivitas bulanan dan kategori yang memengaruhi pengeluaran Anda.</p>
            </a>
            <a href="{{ route('budgets') }}" class="feature-card">
                <div class="icon">Rp</div>
                <h3>Pengelolaan anggaran</h3>
                <p>Tetapkan batas bulanan dan pantau penggunaannya sepanjang bulan.</p>
            </a>
        </div>

        <div class="about-card home-explanation">
            <h2>Kebiasaan sederhana, gambaran lebih jelas.</h2>
            <p>Catat transaksi, pilih kategorinya, lalu lihat ringkasan bulanan di dasbor. Pockettivity membantu Anda memahami keputusan keuangan sehari-hari.</p>
        </div>
    </div>

</section>


<section class="start-section">

    <div>

        <h2>
            Siap mengelola keuangan dengan lebih baik?
        </h2>

        <p>
            Mulai dengan langkah sederhana: catat keuangan harian Anda.
        </p>

        @auth
            <a href="{{ route('dashboard') }}" class="button primary">Buka Dasbor</a>
        @else
            <a href="{{ route('register') }}" class="button primary">Buat Akun</a>
        @endauth

    </div>

</section>

@endsection
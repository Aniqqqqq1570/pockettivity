@extends('layout')

@section('title', 'Tentang Pockettivity')

@section('content')

<section class="about-page">

    <div class="about-container">

        <p class="small-title">
            TENTANG POCKETTIVITY
        </p>

        <h1>
            Keuangan pribadi yang lebih jelas
        </h1>

        <p>
            Pockettivity membantu Anda menata keuangan pribadi dalam satu ruang kerja yang sederhana.
        </p>

        <p>
            Catat pemasukan dan pengeluaran, kelompokkan transaksi, tetapkan anggaran bulanan, dan pahami pola pengeluaran Anda.
        </p>

        <div class="about-card">

            <h2>
                Tujuan Kami
            </h2>

            <p>
                Memudahkan pengelolaan uang sehari-hari agar Anda dapat mengambil keputusan dengan gambaran keuangan yang lebih jelas.
            </p>

        </div>

        <div class="about-card">
            <h2>Mengapa mencatat keuangan?</h2>
            <p>Catatan yang teratur membantu Anda memahami pola pengeluaran, merencanakan kebutuhan bulanan, dan menentukan prioritas berdasarkan aktivitas nyata.</p>
            <p>Pockettivity menyatukan transaksi, kategori, anggaran, dan ringkasan dalam satu tampilan.</p>
        </div>

        <a href="{{ route('home') }}" class="button primary">
            Kembali ke Beranda
        </a>

    </div>

</section>

@endsection
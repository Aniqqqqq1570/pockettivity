@extends('layout')

@section('title', 'Fitur - Pockettivity')

@section('content')

<section class="features-page">

    <div class="features-container">

        <p class="small-title">
            FITUR POCKETTIVITY
        </p>

        <h1>
            Pilih Fitur
        </h1>

        <p class="features-description">
            Gunakan fitur Pockettivity untuk membantu mengatur
            keuangan pribadi.
        </p>


        <div class="features-list">

            <a href="#" class="feature-card">

                <div class="icon">
                    +
                </div>

                <h3>
                    Transaction Recording
                </h3>

                <p>
                    Catat pemasukan dan pengeluaran
                    dengan mudah.
                </p>

            </a>


            <a href="#" class="feature-card">

                <div class="icon">
                    ↗
                </div>

                <h3>
                    Money Analysis
                </h3>

                <p>
                    Lihat analisis dan kondisi keuangan
                    berdasarkan transaksi.
                </p>

            </a>


            <a href="{{ route('transactions') }}" class="feature-card">

                <div class="icon">
                    Rp
                </div>

                <h3>
                    Budget Management
                </h3>

                <p>
                    Atur budget dan pantau penggunaan
                    keuangan.
                </p>

            </a>

        </div>


        <a href="{{ route('home') }}" class="button primary">
            Kembali ke Home
        </a>

    </div>

</section>

@endsection
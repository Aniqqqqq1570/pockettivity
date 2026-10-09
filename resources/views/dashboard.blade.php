
@extends('layout')

@section('title', 'Dasbor - Pockettivity')

@section('content')

<section class="dashboard">

    <div class="dashboard-container">

        <p class="small-title">DASBOR</p>

        <h1>
            Selamat datang, {{ Auth::user()->name }}
        </h1>

        <p>
            Keuangan Anda, tersusun dalam satu tempat.
        </p>


        <div class="dashboard-menu">

            <a href="{{ route('transactions') }}" class="dashboard-feature">

                <div class="feature-icon">
                    +
                </div>

                <div>
                    <h3>
                        Catat Transaksi
                    </h3>

                    <p>
                        Tambahkan dan tinjau pemasukan serta pengeluaran.
                    </p>
                </div>

            </a>


            <a href="{{ route('analysis') }}" class="dashboard-feature">

                <div class="feature-icon">
                    ↗
                </div>

                <div>
                    <h3>
                        Laporan &amp; Analisis
                    </h3>

                    <p>
                        Pahami pengeluaran dan arus kas Anda.
                    </p>
                </div>

            </a>


            <a href="{{ route('budgets') }}" class="dashboard-feature">

                <div class="feature-icon">
                    Rp
                </div>

                <div>
                    <h3>
                        Kelola Anggaran
                    </h3>

                    <p>
                        Tetapkan batas bulanan dan pantau penggunaannya.
                    </p>
                </div>

            </a>

        </div>


        <div class="dashboard-card">

            <h3>
                Ringkasan Keuangan
            </h3>


            <div class="money-summary">


                <div>

                    <span>
                        Pemasukan
                    </span>

                    <strong>
                        {{ \App\Support\MoneyFormatter::format($income) }}
                    </strong>

                </div>


                <div>

                    <span>
                        Pengeluaran
                    </span>

                    <strong>
                        {{ \App\Support\MoneyFormatter::format($expense) }}
                    </strong>

                </div>


                <div>

                    <span>
                        Saldo
                    </span>

                    <strong>
                        {{ \App\Support\MoneyFormatter::format($balance) }}
                    </strong>

                </div>


                <div>
                    <span>Sisa anggaran bulan ini</span>
                    <strong>{{ \App\Support\MoneyFormatter::format($budgetRemaining) }}</strong>
                </div>


            </div>

        </div>

        <div class="dashboard-quick-actions">
            <a href="{{ route('transactions', ['new_type' => 'pemasukan']) }}#transaction-entry" class="button primary">+ Tambah Pemasukan</a>
            <a href="{{ route('transactions', ['new_type' => 'pengeluaran']) }}#transaction-entry" class="button expense-action">− Tambah Pengeluaran</a>
        </div>

        <div class="dashboard-card recent-transactions">
            <div class="recent-transactions-heading">
                <h3>Transaksi Terbaru</h3>
                <a href="{{ route('transactions') }}">Lihat Semua Transaksi</a>
            </div>

            @forelse($latestTransactions as $transaction)
                <div class="recent-transaction-item">
                    <div>
                        <strong>{{ $transaction->description }}</strong>
                        <span>{{ $transaction->category?->name ?? 'Tanpa kategori' }} · {{ $transaction->date }}</span>
                    </div>
                    <strong class="{{ $transaction->type === 'pemasukan' ? 'income' : 'expense' }}">
                        {{ $transaction->type === 'pemasukan' ? '+' : '−' }} {{ \App\Support\MoneyFormatter::format($transaction->amount) }}
                    </strong>
                </div>
            @empty
                <p>Belum ada transaksi. Tambahkan transaksi pertama untuk melihatnya di sini.</p>
            @endforelse
        </div>
    </div>

</section>

@endsection


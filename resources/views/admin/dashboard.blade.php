
@extends('layout')

@section('title', 'Dasbor Admin | Pockettivity')

@section('content')

<section class="dashboard">

    <div class="dashboard-container">

        <div class="admin-header">

            <p class="small-title">
                    PANEL ADMIN
            </p>

            <h1>
                Dasbor Admin
            </h1>

            <p>
                Selamat datang, {{ Auth::user()->name }}.
            </p>

        </div>


        <nav class="admin-shortcuts" aria-label="Pintasan admin">

            <a
                href="{{ route('admin.users') }}"
                class="admin-shortcut-link"
            >
                Kelola Pengguna
            </a>

            <a href="{{ route('admin.transactions') }}" class="admin-shortcut-link">
                Transaksi
            </a>

        </nav>


        <div class="admin-statistics">

            <div class="admin-stat-card">

                <div class="stat-icon">
                    U
                </div>

                <div>
                    <span>
                        Total Pengguna
                    </span>

                    <h2>
                        {{ $users }}
                    </h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon">
                    A
                </div>

                <div>
                    <span>Total Admin</span>
                    <h2>{{ $admins }}</h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon">
                    U
                </div>

                <div>
                    <span>Pengguna</span>
                    <h2>{{ $normalUsers }}</h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon">
                    T
                </div>

                <div>
                    <span>
                        Total Transaksi
                    </span>

                    <h2>
                        {{ $transactions }}
                    </h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon income-icon">
                    +
                </div>

                <div>
                    <span>
                        Total Pemasukan
                    </span>

                    <h2>
                        {{ \App\Support\MoneyFormatter::format($income) }}
                    </h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon expense-icon">
                    −
                </div>

                <div>
                    <span>
                        Total Pengeluaran
                    </span>

                    <h2>
                        {{ \App\Support\MoneyFormatter::format($expense) }}
                    </h2>
                </div>

            </div>

        </div>


        <div class="admin-transactions">

            <div class="admin-section-header">

                <div>

                    <h3>
                        Transaksi Terbaru
                    </h3>

                    <p>
                        Aktivitas terbaru seluruh akun.
                    </p>

                </div>

            </div>


            @if($transactionList->count() > 0)

                <div class="admin-transaction-list">

                    @foreach($transactionList as $transaction)

                        <div class="admin-transaction-item">

                            <div class="transaction-user-avatar">
                                {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                            </div>


                            <div class="admin-transaction-info">

                                <strong>
                                    {{ $transaction->description }}
                                </strong>

                                <span>
                                    {{ $transaction->user->name }}
                                </span>

                                <span>
                                    {{ $transaction->category?->name ?? 'Tanpa kategori' }}
                                </span>

                                <small>
                                    {{ $transaction->date }}
                                </small>

                            </div>

                            <div class="admin-transaction-amount">

                                @if($transaction->type == 'pemasukan')

                                    <strong class="admin-income">
                                        + {{ \App\Support\MoneyFormatter::format($transaction->amount) }}
                                    </strong>

                                @else

                                    <strong class="admin-expense">
                                        - {{ \App\Support\MoneyFormatter::format($transaction->amount) }}
                                    </strong>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty-transactions">

                    <p>
                        Belum ada transaksi.
                    </p>

                </div>

            @endif

        </div>

        <div class="admin-shortcuts">
            <a href="{{ route('admin.transactions') }}" class="admin-shortcut-link">
                Lihat Semua Transaksi
            </a>
        </div>


        <form
            action="{{ route('logout') }}"
            method="POST"
            class="admin-logout"
        >

            @csrf

            <button
                type="submit"
                class="logout-button"
            >
                Keluar
            </button>

        </form>

    </div>

</section>

@endsection


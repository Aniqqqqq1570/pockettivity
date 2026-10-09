
@extends('layout')

@section('title', 'Transaksi | Pockettivity')

@section('content')

<section class="transaction-page">

    <div class="transaction-container">

        <div class="transaction-header">

            <div>

                <p class="small-title">
                    TRANSAKSI
                </p>

                <h1>
                    Transaksi
                </h1>

                <p>
                    Catat dan tinjau pemasukan serta pengeluaran Anda.
                </p>

            </div>

        </div>


        <form action="{{ route('transactions') }}" method="GET" class="transaction-filter-form">
            <div>
                <label for="search">Cari keterangan</label>
                <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari transaksi">
            </div>
            <div>
                <label for="filter_type">Jenis</label>
                <select id="filter_type" name="type">
                    <option value="">Semua jenis</option>
                    <option value="pemasukan" {{ ($filters['type'] ?? '') === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ ($filters['type'] ?? '') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div>
                <label for="filter_category">Kategori</label>
                <select id="filter_category" name="category_id">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date_from">Dari tanggal</label>
                <input id="date_from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
            </div>
            <div>
                <label for="date_to">Sampai tanggal</label>
                <input id="date_to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
            </div>
            <div>
                <label for="sort">Urutkan</label>
                <select id="sort" name="sort">
                    <option value="newest" {{ ($filters['sort'] ?? 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="highest" {{ ($filters['sort'] ?? '') === 'highest' ? 'selected' : '' }}>Nominal terbesar</option>
                    <option value="lowest" {{ ($filters['sort'] ?? '') === 'lowest' ? 'selected' : '' }}>Nominal terkecil</option>
                </select>
            </div>
            <div class="transaction-filter-actions">
                <button type="submit" class="transaction-button">Terapkan Filter</button>
                <a href="{{ route('transactions') }}" class="button secondary">Hapus Filter</a>
            </div>
        </form>


        @php

            $income = $transactions
                ->where('type', 'pemasukan')
                ->sum('amount');

            $expense = $transactions
                ->where('type', 'pengeluaran')
                ->sum('amount');

            $balance = $income - $expense;

        @endphp


        <div class="transaction-summary">

            <div class="summary-box">

                <span>
                    Total Pemasukan
                </span>

                <h2>
                    {{ \App\Support\MoneyFormatter::format($income) }}
                </h2>

            </div>


            <div class="summary-box">

                <span>
                    Total Pengeluaran
                </span>

                <h2>
                    {{ \App\Support\MoneyFormatter::format($expense) }}
                </h2>

            </div>


            <div class="summary-box">

                <span>
                    Saldo
                </span>

                <h2>
                    {{ \App\Support\MoneyFormatter::format($balance) }}
                </h2>

            </div>

        </div>


        <div class="transaction-content">


            <div class="transaction-form dashboard-card" id="transaction-entry">

                <h3>
                    Tambah Transaksi
                </h3>

                <p>
                    Tambahkan catatan pemasukan atau pengeluaran.
                </p>


                @include('partials.ui-alerts')


                <form
                    action="{{ route('transactions.store') }}"
                    method="POST"
                >

                    @csrf


                    <label for="transaction-type">
                        Jenis
                    </label>

                    <select id="transaction-type" name="type" required>

                        <option value="pemasukan" {{ old('type', $defaultType) === 'pemasukan' ? 'selected' : '' }}>
                            Pemasukan
                        </option>

                        <option value="pengeluaran" {{ old('type', $defaultType) === 'pengeluaran' ? 'selected' : '' }}>
                            Pengeluaran
                        </option>

                    </select>

                    <label for="category_id">
                        Kategori
                    </label>

                    <select name="category_id" id="category_id" required>
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @if($categories->isEmpty())
                        <p class="form-hint">
                            Buat kategori sebelum menambahkan transaksi.
                            <a href="{{ route('categories') }}">Kelola Kategori</a>
                        </p>
                    @endif


                    <label for="transaction-amount">
                        Nominal
                    </label>

                    <input
                        id="transaction-amount"
                        type="text"
                        name="amount"
                        data-money-input
                        data-money-min="0.01"
                        value="{{ \App\Support\MoneyFormatter::forInput(old('amount')) }}"
                        placeholder="Contoh: 500.000"
                        autocomplete="off"
                        required
                    >


                    <label>
                        Keterangan
                    </label>

                    <input
                        type="text"
                        name="description"
                        placeholder="Contoh: gaji, belanja, atau transportasi"
                        required
                    >


                    <label>
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="date"
                        required
                    >


                    <button
                        type="submit"
                        class="transaction-button"
                    >
                        Tambah Transaksi
                    </button>

                </form>

            </div>


            <div class="transaction-list dashboard-card">

                <div class="transaction-list-header">

                    <div>

                        <h3>
                            Riwayat Transaksi
                        </h3>

                        <p>
                            Aktivitas terbaru Anda
                        </p>

                    </div>

                </div>


                @if($transactions->count() > 0)

                    <div class="transaction-table">

                        @foreach($transactions as $transaction)

                            <div class="transaction-item">

                                <div class="transaction-icon">

                                    @if($transaction->type == 'pemasukan')

                                        +

                                    @else

                                        -

                                    @endif

                                </div>


                                <div class="transaction-info">

                                    <strong>
                                        {{ $transaction->description }}
                                    </strong>

                                    <span>
                                        {{ $transaction->date }}
                                    </span>

                                    <span class="transaction-category">
                                        {{ $transaction->category?->name ?? 'Tanpa kategori' }}
                                    </span>

                                </div>


                                <div class="transaction-amount">

                                    @if($transaction->type == 'pemasukan')

                                        <strong class="income">
                                            + {{ \App\Support\MoneyFormatter::format($transaction->amount) }}
                                        </strong>

                                        <span class="income-label">
                                            Pemasukan
                                        </span>

                                    @else

                                        <strong class="expense">
                                            - {{ \App\Support\MoneyFormatter::format($transaction->amount) }}
                                        </strong>

                                        <span class="expense-label">
                                            Pengeluaran
                                        </span>

                                    @endif

                                </div>


                                <a
                                    href="{{ route('transactions.edit', $transaction->id) }}"
                                    class="edit-button"
                                >
                                    Ubah
                                </a>


                                <form
                                    action="{{ route('transactions.destroy', $transaction->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="delete-button"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="empty-transaction">

                        <div class="empty-icon">
                            Rp
                        </div>

                        <h4>
                            Belum ada transaksi
                        </h4>

                        <p>
                            Tambahkan transaksi pertama melalui formulir di samping riwayat ini.
                        </p>
                        <a href="#transaction-entry" class="button primary">Tambah Transaksi</a>

                    </div>

                @endif

            </div>

        </div>


        <a
            href="{{ route('features') }}"
            class="button secondary"
        >
            Kembali ke Fitur
        </a>

        <a href="{{ route('categories') }}" class="button secondary">
            Kelola Kategori
        </a>

    </div>

</section>

@endsection


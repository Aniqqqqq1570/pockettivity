@extends('layout')

@section('title', 'Semua Transaksi | Pockettivity')

@section('content')
<section class="dashboard">
    <div class="dashboard-container">
        <div class="admin-header">
            <p class="small-title">PANEL ADMIN</p>
            <h1>Semua Transaksi</h1>
            <p>Tinjau aktivitas keuangan seluruh akun.</p>
        </div>

        @include('partials.ui-alerts')

        <form action="{{ route('admin.transactions') }}" method="GET" class="admin-filter-form">
            <div>
                <label for="user_id">Pengguna</label>
                <select id="user_id" name="user_id">
                    <option value="">Semua pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="type">Jenis</label>
                <select id="type" name="type">
                    <option value="">Semua jenis</option>
                    <option value="pemasukan" {{ ($filters['type'] ?? '') === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ ($filters['type'] ?? '') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div>
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }} · {{ $category->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date">Tanggal</label>
                <input id="date" type="date" name="date" value="{{ $filters['date'] ?? '' }}">
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="admin-button">Terapkan Filter</button>
                <a href="{{ route('admin.transactions') }}" class="button secondary">Hapus Filter</a>
            </div>
        </form>

        <div class="admin-transactions">
            <div class="admin-section-header">
                <h3>Riwayat Transaksi</h3>
                <p>{{ $transactions->total() }} transaksi ditemukan</p>
            </div>

            @forelse($transactions as $transaction)
                <div class="admin-transaction-item">
                    <div class="transaction-user-avatar">{{ strtoupper(substr($transaction->user->name, 0, 1)) }}</div>
                    <div class="admin-transaction-info">
                        <strong>{{ $transaction->description }}</strong>
                        <span>{{ $transaction->user->name }} · {{ $transaction->category?->name ?? 'Tanpa kategori' }}</span>
                        <small>{{ $transaction->date }}</small>
                    </div>
                    <div class="admin-transaction-amount">
                        @if($transaction->type === 'pemasukan')
                            <strong class="admin-income">+ {{ \App\Support\MoneyFormatter::format($transaction->amount) }}</strong>
                        @else
                            <strong class="admin-expense">− {{ \App\Support\MoneyFormatter::format($transaction->amount) }}</strong>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-transactions"><p>Tidak ada transaksi yang sesuai dengan filter.</p></div>
            @endforelse
        </div>

        <div class="admin-pagination">{{ $transactions->links('pagination.pockettivity') }}</div>
        <a href="{{ route('admin.dashboard') }}" class="button secondary">Kembali ke Dasbor</a>
    </div>
</section>
@endsection
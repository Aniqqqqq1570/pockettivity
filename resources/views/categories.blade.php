@extends('layout')

@section('title', 'Kategori | Pockettivity')

@section('content')
<section class="transaction-page category-page">
    <div class="transaction-container">
        <div class="transaction-header">
            <p class="small-title">PENGELOLAAN KATEGORI</p>
            <h1>Kategori</h1>
            <p>Kelompokkan pemasukan dan pengeluaran sesuai kebutuhan Anda.</p>
        </div>

        @include('partials.ui-alerts', ['alertClass' => 'category-alert'])

        <div class="category-layout">
            <div class="transaction-form dashboard-card" id="category-create">
                <h3>Tambah Kategori</h3>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <label for="name">Nama kategori</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" maxlength="100" required>
                    <button type="submit" class="transaction-button">Tambah Kategori</button>
                </form>
            </div>

            <div class="category-list dashboard-card">
                <h3>Daftar Kategori</h3>
                @forelse($categories as $category)
                    <div class="category-item">
                        <form action="{{ route('categories.update', $category) }}" method="POST" class="category-edit-form">
                            @csrf
                            @method('PUT')
                            <label class="visually-hidden" for="category-{{ $category->id }}">Nama kategori</label>
                            <input id="category-{{ $category->id }}" type="text" name="name" value="{{ $category->name }}" maxlength="100" required>
                            <button type="submit" class="edit-button">Simpan Perubahan</button>
                        </form>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Transaksi terkait akan menjadi tanpa kategori.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Hapus</button>
                        </form>
                    </div>
                @empty
                    <div class="empty-transaction">
                        <h4>Belum ada kategori</h4>
                        <p>Tambahkan kategori untuk mengelompokkan transaksi.</p>
                        <a href="#category-create" class="button primary">Tambah Kategori</a>
                    </div>
                @endforelse
            </div>
        </div>

        <a href="{{ route('transactions') }}" class="button secondary">Kembali ke Transaksi</a>
    </div>
</section>
@endsection
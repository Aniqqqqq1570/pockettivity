@extends('layout')

@section('title', 'Anggaran | Pockettivity')

@section('content')
<section class="transaction-page">
    <div class="transaction-container">
        <div class="transaction-header">
            <p class="small-title">PERENCANAAN BULANAN</p>
            <h1>Anggaran</h1>
            <p>Tetapkan batas pengeluaran per kategori dan pantau penggunaannya setiap bulan.</p>
        </div>

        @include('partials.ui-alerts', ['alertClass' => 'category-alert'])

        @if($categories->isEmpty())
            <div class="dashboard-card budget-empty">
                <h3>Buat kategori terlebih dahulu</h3>
                <p>Anggaran dikelompokkan berdasarkan kategori. Tambahkan kategori untuk memulai.</p>
                <a href="{{ route('categories') }}" class="transaction-button">Kelola Kategori</a>
            </div>
        @else
            <div class="transaction-form dashboard-card budget-create" id="budget-create">
                <h3>Tambah Anggaran</h3>
                <form action="{{ route('budgets.store') }}" method="POST" class="budget-form">
                    @csrf
                    <div>
                        <label for="category_id">Kategori</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="amount">Nominal anggaran</label>
                        <input id="amount" type="text" name="amount" data-money-input data-money-min="0.01" value="{{ \App\Support\MoneyFormatter::forInput(old('amount')) }}" placeholder="Contoh: 1.500.000" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="month">Bulan</label>
                        <select id="month" name="month" required>
                            @foreach($months as $number => $monthName)
                                <option value="{{ $number }}" {{ old('month', now()->month) == $number ? 'selected' : '' }}>{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="year">Tahun</label>
                        <input id="year" type="number" name="year" min="2000" max="2100" value="{{ old('year', now()->year) }}" required>
                    </div>
                    <button type="submit" class="transaction-button">Tambah Anggaran</button>
                </form>
            </div>
        @endif

        <div class="budget-list">
            @forelse($budgets as $budget)
                @php
                    $percentage = $budget->amount > 0 ? round(($budget->used / $budget->amount) * 100) : 0;
                    $progressState = $budget->used > $budget->amount ? 'over' : ($percentage >= 80 ? 'near' : 'safe');
                    $remaining = max(0, $budget->amount - $budget->used);
                @endphp
                <article class="budget-item">
                    <div class="budget-item-heading">
                        <div>
                            <h3>{{ $budget->category->name }}</h3>
                            <p>{{ $months[$budget->month] }} {{ $budget->year }}</p>
                        </div>
                        <strong class="budget-status {{ $progressState }}">
                            @if($progressState === 'over') Melebihi anggaran @elseif($progressState === 'near') Mendekati batas @else Sesuai anggaran @endif
                        </strong>
                    </div>

                    <div class="budget-numbers">
                        <span>Terpakai <strong>{{ \App\Support\MoneyFormatter::format($budget->used) }}</strong></span>
                        <span>Sisa <strong>{{ \App\Support\MoneyFormatter::format($remaining) }}</strong></span>
                        <span>Anggaran <strong>{{ \App\Support\MoneyFormatter::format($budget->amount) }}</strong></span>
                    </div>

                    <div class="budget-progress-track" role="progressbar" aria-label="Penggunaan anggaran kategori {{ $budget->category->name }}" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ min(100, $percentage) }}">
                        <span class="{{ $progressState }}" style="width: {{ min(100, $percentage) }}%"></span>
                    </div>
                    <p class="budget-percent">{{ $percentage }}% terpakai</p>

                    <details class="budget-edit">
                        <summary>Ubah Anggaran</summary>
                        <form action="{{ route('budgets.update', $budget) }}" method="POST" class="budget-form">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="category-{{ $budget->id }}">Kategori</label>
                                <select id="category-{{ $budget->id }}" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $budget->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="amount-{{ $budget->id }}">Nominal anggaran</label>
                                <input id="amount-{{ $budget->id }}" type="text" name="amount" data-money-input data-money-min="0.01" value="{{ \App\Support\MoneyFormatter::forInput(old('amount', $budget->amount)) }}" autocomplete="off" required>
                            </div>
                            <div>
                                <label for="month-{{ $budget->id }}">Bulan</label>
                                <select id="month-{{ $budget->id }}" name="month" required>
                                    @foreach($months as $number => $monthName)
                                        <option value="{{ $number }}" {{ $budget->month == $number ? 'selected' : '' }}>{{ $monthName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="year-{{ $budget->id }}">Tahun</label>
                                <input id="year-{{ $budget->id }}" type="number" name="year" min="2000" max="2100" value="{{ $budget->year }}" required>
                            </div>
                            <button type="submit" class="transaction-button">Simpan Perubahan</button>
                        </form>
                    </details>

                    <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggaran ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">Hapus</button>
                    </form>
                </article>
            @empty
                <div class="empty-transaction dashboard-card">
                        <h4>Belum ada anggaran</h4>
                        <p>Tambahkan anggaran untuk mulai memantau pengeluaran bulanan.</p>
                        <a href="#budget-create" class="button primary">Tambah Anggaran</a>
                </div>
            @endforelse
        </div>

        <a href="{{ route('dashboard') }}" class="button secondary">Kembali ke Dasbor</a>
    </div>
</section>
@endsection
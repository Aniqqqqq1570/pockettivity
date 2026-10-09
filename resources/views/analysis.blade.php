@extends('layout')

@section('title', 'Analisis | Pockettivity')

@section('content')
@php
    $analysisMonthLabels = [
        'Januari' => 'Jan', 'Februari' => 'Feb', 'Maret' => 'Mar', 'April' => 'Apr',
        'Mei' => 'Mei', 'Juni' => 'Jun', 'Juli' => 'Jul', 'Agustus' => 'Agu',
        'September' => 'Sep', 'Oktober' => 'Okt', 'November' => 'Nov', 'Desember' => 'Des',
        'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
        'Jun' => 'Jun', 'Jul' => 'Jul', 'Agt' => 'Agu', 'Sep' => 'Sep',
        'Okt' => 'Okt', 'Nov' => 'Nov', 'Des' => 'Des',
    ];
@endphp
<section class="transaction-page">
    <div class="transaction-container">
        <div class="transaction-header">
            <p class="small-title">RINGKASAN KEUANGAN</p>
            <h1>Analisis</h1>
            <p>Pahami arus kas, anggaran bulanan, dan pola pengeluaran Anda.</p>
        </div>

        <div class="analysis-summary">
            <div class="analysis-stat income-stat"><span>Total Pemasukan</span><strong>{{ \App\Support\MoneyFormatter::format($income) }}</strong></div>
            <div class="analysis-stat expense-stat"><span>Total Pengeluaran</span><strong>{{ \App\Support\MoneyFormatter::format($expense) }}</strong></div>
            <div class="analysis-stat"><span>Anggaran Bulan Ini</span><strong>{{ \App\Support\MoneyFormatter::format($currentMonthBudget) }}</strong></div>
            <div class="analysis-stat"><span>Sisa Anggaran</span><strong>{{ \App\Support\MoneyFormatter::format($remainingBudget) }}</strong></div>
            <div class="analysis-stat"><span>Saldo</span><strong>{{ \App\Support\MoneyFormatter::format($balance) }}</strong></div>
            <div class="analysis-stat"><span>Jumlah Transaksi</span><strong>{{ $transactionCount }}</strong></div>
            <div class="analysis-stat income-stat"><span>Pemasukan Bulan Ini</span><strong>{{ \App\Support\MoneyFormatter::format($currentMonthIncome) }}</strong></div>
            <div class="analysis-stat expense-stat"><span>Pengeluaran Bulan Ini</span><strong>{{ \App\Support\MoneyFormatter::format($currentMonthExpense) }}</strong></div>
        </div>

        <div class="analysis-grid">
            <section class="analysis-panel">
                <h2>Pemasukan &amp; Pengeluaran</h2>
                <div class="comparison-bars">
                    @php($maximumAmount = max($income, $expense, 1))
                    <div class="comparison-row">
                        <span>Pemasukan</span>
                        <div class="analysis-bar-track"><span class="income-bar" style="width: {{ min(100, ($income / $maximumAmount) * 100) }}%"></span></div>
                        <strong>{{ \App\Support\MoneyFormatter::format($income) }}</strong>
                    </div>
                    <div class="comparison-row">
                        <span>Pengeluaran</span>
                        <div class="analysis-bar-track"><span class="expense-bar" style="width: {{ min(100, ($expense / $maximumAmount) * 100) }}%"></span></div>
                        <strong>{{ \App\Support\MoneyFormatter::format($expense) }}</strong>
                    </div>
                </div>
            </section>

            <section class="analysis-panel">
                <h2>Pengeluaran per Kategori</h2>
                @if($expensesByCategory->isEmpty())
                    <p class="analysis-empty">Belum ada data pengeluaran. Tambahkan pengeluaran untuk melihat rinciannya.</p>
                @else
                    @php($highestAmount = max(1, $expensesByCategory->first()))
                    <p class="analysis-highlight">Kategori pengeluaran terbesar: <strong>{{ $highestCategory }}</strong></p>
                    <div class="category-analysis-list">
                        @foreach($expensesByCategory as $categoryName => $amount)
                            <div class="category-analysis-item">
                                <div><span>{{ $categoryName }}</span><strong>{{ \App\Support\MoneyFormatter::format($amount) }}</strong></div>
                                <div class="analysis-bar-track"><span class="expense-bar" style="width: {{ min(100, ($amount / $highestAmount) * 100) }}%"></span></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <section class="analysis-panel monthly-analysis">
            <h2>Ringkasan Enam Bulan</h2>
            <div class="monthly-summary-list">
                @foreach($monthlySummary as $summary)
                    @php($monthTotal = max(1, $summary['income'], $summary['expense']))
                    @php([$monthName, $monthYear] = array_pad(explode(' ', $summary['label'], 2), 2, ''))
                    <div class="monthly-summary-item">
                        <strong class="monthly-label">{{ $analysisMonthLabels[$monthName] ?? $monthName }} {{ $monthYear }}</strong>
                        <div class="monthly-bars">
                            <div class="analysis-bar-track"><span class="income-bar" style="width: {{ min(100, ($summary['income'] / $monthTotal) * 100) }}%"></span></div>
                            <div class="analysis-bar-track"><span class="expense-bar" style="width: {{ min(100, ($summary['expense'] / $monthTotal) * 100) }}%"></span></div>
                        </div>
                        <div class="monthly-values">
                            <span class="income">{{ \App\Support\MoneyFormatter::format($summary['income']) }}</span>
                            <span class="expense">{{ \App\Support\MoneyFormatter::format($summary['expense']) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="analysis-legend"><span class="legend-income"></span> Pemasukan <span class="legend-expense"></span> Pengeluaran</p>
        </section>

        <section class="analysis-panel recent-analysis">
            <h2>Transaksi Terbaru</h2>
            @forelse($recentTransactions as $transaction)
                <div class="analysis-recent-item">
                    <div>
                        <strong>{{ $transaction->description }}</strong>
                        <span>{{ $transaction->category?->name ?? 'Tanpa kategori' }} · {{ $transaction->date }}</span>
                    </div>
                    <strong class="{{ $transaction->type === 'pemasukan' ? 'income' : 'expense' }}">
                        {{ $transaction->type === 'pemasukan' ? '+' : '−' }} {{ \App\Support\MoneyFormatter::format($transaction->amount) }}
                    </strong>
                </div>
            @empty
                <p class="analysis-empty">Belum ada transaksi. Tambahkan transaksi untuk melihat aktivitas terbaru.</p>
            @endforelse
        </section>

        <section class="analysis-panel ai-analysis-panel">
            <div class="ai-analysis-heading">
                <div>
                    <p class="small-title">WAWASAN PERSONAL</p>
                    <h2>Analisis AI</h2>
                </div>
                <form action="{{ route('analysis.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-button">Buat Analisis</button>
                </form>
            </div>

            @include('partials.ui-alerts', ['alertClass' => 'ai-message'])

            @if($aiAnalysis)
                <div class="ai-analysis-result">{!! nl2br(e($aiAnalysis)) !!}</div>
            @else
                <p class="analysis-empty">Buat ringkasan pengeluaran, anggaran, dan kebiasaan menabung berdasarkan data akun Anda.</p>
            @endif
        </section>

        <a href="{{ route('dashboard') }}" class="button secondary">Kembali ke Dasbor</a>
    </div>
</section>
@endsection
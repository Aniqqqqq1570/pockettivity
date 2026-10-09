@extends('layout')

@section('title', 'Mutasi Bulanan - Pockettivity')

@section('content')
<main class="monthly-statement-page">
    <div class="statement-container">
        <div class="statement-page-heading">
            <div>
                <p class="statement-eyebrow">LAPORAN KEUANGAN</p>
                <h1>Mutasi Bulanan</h1>
                <p>Ringkasan arus kas dan transaksi untuk {{ $periodLabel }}.</p>
            </div>
            <a class="statement-dashboard-link" href="{{ route('dashboard') }}">Kembali ke Dasbor</a>
        </div>

        @if($errors->any())
            <div class="statement-validation" role="alert">{{ $errors->first() }}</div>
        @endif

        <form class="statement-filter" method="GET" action="{{ route('monthly-statement') }}">
            <label>
                <span>Bulan</span>
                <select name="month" required>
                    @foreach($months as $index => $label)
                        <option value="{{ $index + 1 }}" @selected($month === $index + 1)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span>Tahun</span>
                <input type="number" name="year" min="1900" max="2100" value="{{ $year }}" required>
            </label>
            <button class="statement-button statement-button-primary" type="submit">Tampilkan</button>
            <a class="statement-button statement-button-subtle" href="{{ route('monthly-statement', ['month' => $currentMonth, 'year' => $currentYear]) }}">Bulan Ini</a>
        </form>

        <nav class="statement-period-nav" aria-label="Navigasi bulan laporan">
            <a href="{{ route('monthly-statement', ['month' => $previousPeriod->month, 'year' => $previousPeriod->year]) }}" aria-label="Bulan sebelumnya">&larr; Sebelumnya</a>
            <strong>{{ $periodLabel }}</strong>
            <a href="{{ route('monthly-statement', ['month' => $nextPeriod->month, 'year' => $nextPeriod->year]) }}" aria-label="Bulan berikutnya">Berikutnya &rarr;</a>
        </nav>

        <div class="statement-actions" aria-label="Aksi laporan">
            <a class="statement-button statement-button-primary" href="{{ route('monthly-statement.print', ['month' => $month, 'year' => $year]) }}">Cetak Laporan</a>
            <a class="statement-button statement-button-secondary" href="{{ route('monthly-statement.pdf', ['month' => $month, 'year' => $year]) }}">Unduh PDF</a>
        </div>

        @include('monthly-statement.report')
    </div>
</main>
@endsection
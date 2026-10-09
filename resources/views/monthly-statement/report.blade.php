<article class="statement-report">
    <header class="report-brand-row">
        <div class="report-brand"><span class="report-brand-mark">P</span><span>Pockettivity</span></div>
        <p class="report-generated">Dibuat {{ $generatedAt->format('d/m/Y H:i') }}</p>
    </header>

    <div class="report-title-row">
        <div>
            <p class="report-kicker">LAPORAN KEUANGAN</p>
            <h2>Laporan Mutasi Keuangan Bulanan</h2>
        </div>
        <strong class="report-period">{{ $periodLabel }}</strong>
    </div>

    <div class="report-owner">
        <span>{{ $user->name }}</span>
        <span>{{ $user->email }}</span>
    </div>

    <section class="report-balances" aria-label="Ringkasan saldo">
        <div><span>Saldo Awal</span><strong>{{ $openingBalance }}</strong></div>
        <div class="report-income"><span>Total Pemasukan</span><strong>{{ $income }}</strong></div>
        <div class="report-expenses"><span>Total Pengeluaran</span><strong>{{ $expenses }}</strong></div>
        <div><span>Arus Kas Bersih</span><strong>{{ $netCashFlow }}</strong></div>
        <div class="report-closing"><span>Saldo Akhir</span><strong>{{ $closingBalance }}</strong></div>
        <div><span>Jumlah Transaksi</span><strong>{{ number_format($transactionCount, 0, ',', '.') }}</strong></div>
    </section>

    <p class="report-assumption">Saldo awal dihitung dari pemasukan dan pengeluaran yang tercatat sebelum periode ini. Transaksi sebelum data Pockettivity mulai dicatat tidak termasuk dalam saldo.</p>

    <div class="report-ledger-wrap">
        <table class="report-ledger">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Jenis</th>
                    <th scope="col" class="report-amount">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->statement_date }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->category?->name ?? 'Tanpa kategori' }}</td>
                        <td class="{{ $transaction->type === 'pemasukan' ? 'report-income' : ($transaction->type === 'pengeluaran' ? 'report-expenses' : '') }}">{{ $transaction->statement_type }}</td>
                        <td class="report-amount {{ $transaction->type === 'pemasukan' ? 'report-income' : ($transaction->type === 'pengeluaran' ? 'report-expenses' : '') }}">{{ $transaction->statement_amount }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="report-empty" colspan="5">Tidak ada transaksi pada {{ $periodLabel }}.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total pemasukan</th>
                    <td class="report-amount report-income">{{ $income }}</td>
                </tr>
                <tr>
                    <th colspan="4">Total pengeluaran</th>
                    <td class="report-amount report-expenses">{{ $expenses }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</article>
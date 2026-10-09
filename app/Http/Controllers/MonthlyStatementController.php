<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Support\MoneyFormatter;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MonthlyStatementController extends Controller
{
    private const MONTHS = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    ];

    public function index(Request $request): View
    {
        return view('monthly-statement', $this->statementData($request));
    }

    public function print(Request $request): View
    {
        return view('monthly-statement.print', $this->statementData($request) + [
            'autoPrint' => true,
            'showActions' => true,
        ]);
    }

    public function download(Request $request): Response
    {
        $statement = $this->statementData($request);
        $filename = sprintf('laporan-mutasi-%04d-%02d.pdf', $statement['year'], $statement['month']);

        return Pdf::loadView('monthly-statement.print', $statement + [
            'autoPrint' => false,
            'showActions' => false,
        ])->setPaper('a4', 'portrait')->download($filename);
    }

    private function statementData(Request $request): array
    {
        $filters = $request->validate([
            'month' => ['sometimes', 'required', 'integer', 'between:1,12'],
            'year' => ['sometimes', 'required', 'integer', 'between:1900,2100'],
        ], [
            'month.between' => 'Bulan laporan tidak valid.',
            'year.between' => 'Tahun laporan harus antara 1900 dan 2100.',
        ]);

        $month = (int) ($filters['month'] ?? now()->month);
        $year = (int) ($filters['year'] ?? now()->year);
        $start = CarbonImmutable::create($year, $month, 1, 0, 0, 0, config('app.timezone'));
        $nextMonth = $start->addMonth();
        $startDate = $start->toDateString();
        $nextMonthDate = $nextMonth->toDateString();
        $user = $request->user();

        $totals = $user->transactions()
            ->selectRaw(<<<'SQL'
                COUNT(*) AS transaction_count,
                COALESCE(SUM(CASE
                    WHEN date < ? AND type = 'pemasukan' THEN CAST(ROUND(amount * 100) AS BIGINT)
                    WHEN date < ? AND type = 'pengeluaran' THEN -CAST(ROUND(amount * 100) AS BIGINT)
                    ELSE 0
                END), 0) AS opening_balance,
                COALESCE(SUM(CASE
                    WHEN date >= ? AND date < ? AND type = 'pemasukan' THEN CAST(ROUND(amount * 100) AS BIGINT)
                    ELSE 0
                END), 0) AS income,
                COALESCE(SUM(CASE
                    WHEN date >= ? AND date < ? AND type = 'pengeluaran' THEN CAST(ROUND(amount * 100) AS BIGINT)
                    ELSE 0
                END), 0) AS expenses,
                COALESCE(SUM(CASE
                    WHEN date >= ? AND date < ? AND type = 'pemasukan' THEN CAST(ROUND(amount * 100) AS BIGINT)
                    WHEN date >= ? AND date < ? AND type = 'pengeluaran' THEN -CAST(ROUND(amount * 100) AS BIGINT)
                    ELSE 0
                END), 0) AS net_cash_flow,
                COALESCE(SUM(CASE
                    WHEN date < ? AND type = 'pemasukan' THEN CAST(ROUND(amount * 100) AS BIGINT)
                    WHEN date < ? AND type = 'pengeluaran' THEN -CAST(ROUND(amount * 100) AS BIGINT)
                    WHEN date >= ? AND date < ? AND type = 'pemasukan' THEN CAST(ROUND(amount * 100) AS BIGINT)
                    WHEN date >= ? AND date < ? AND type = 'pengeluaran' THEN -CAST(ROUND(amount * 100) AS BIGINT)
                    ELSE 0
                END), 0) AS closing_balance
                SQL, [
                $startDate, $startDate,
                $startDate, $nextMonthDate,
                $startDate, $nextMonthDate,
                $startDate, $nextMonthDate, $startDate, $nextMonthDate,
                $startDate, $startDate,
                $startDate, $nextMonthDate, $startDate, $nextMonthDate,
            ])
            ->first();

        $transactions = $user->transactions()
            ->with('category')
            ->where('date', '>=', $startDate)
            ->where('date', '<', $nextMonthDate)
            ->orderBy('date')
            ->orderBy('id')
            ->get()
            ->each(function (Transaction $transaction): void {
                $transaction->setAttribute(
                    'statement_date',
                    CarbonImmutable::parse($transaction->date)->format('d/m/Y')
                );
                $transaction->setAttribute('statement_amount', MoneyFormatter::format($transaction->amount));
                $transaction->setAttribute('statement_type', match ($transaction->type) {
                    'pemasukan' => 'Pemasukan',
                    'pengeluaran' => 'Pengeluaran',
                    default => 'Lainnya',
                });
            });

        $now = now();

        return [
            'month' => $month,
            'year' => $year,
            'months' => self::MONTHS,
            'periodLabel' => self::MONTHS[$month - 1].' '.$year,
            'previousPeriod' => $start->subMonth(),
            'nextPeriod' => $nextMonth,
            'currentMonth' => (int) $now->month,
            'currentYear' => (int) $now->year,
            'generatedAt' => $now,
            'user' => $user,
            'transactionCount' => (int) $totals->transaction_count,
            'openingBalance' => MoneyFormatter::formatCents($totals->opening_balance),
            'income' => MoneyFormatter::formatCents($totals->income),
            'expenses' => MoneyFormatter::formatCents($totals->expenses),
            'netCashFlow' => MoneyFormatter::formatCents($totals->net_cash_flow),
            'closingBalance' => MoneyFormatter::formatCents($totals->closing_balance),
            'transactions' => $transactions,
        ];
    }
}

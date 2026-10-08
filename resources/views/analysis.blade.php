@extends('layout')

@section('title', 'Analysis | Pockettivity')

@section('content')
@php
    $analysisMonthLabels = [
        'Januari' => 'Jan', 'Februari' => 'Feb', 'Maret' => 'Mar', 'April' => 'Apr',
        'Mei' => 'May', 'Juni' => 'Jun', 'Juli' => 'Jul', 'Agustus' => 'Aug',
        'September' => 'Sep', 'Oktober' => 'Oct', 'November' => 'Nov', 'Desember' => 'Dec',
        'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
        'Jun' => 'Jun', 'Jul' => 'Jul', 'Agt' => 'Aug', 'Sep' => 'Sep',
        'Okt' => 'Oct', 'Nov' => 'Nov', 'Des' => 'Dec',
    ];
@endphp
<section class="transaction-page">
    <div class="transaction-container">
        <div class="transaction-header">
            <p class="small-title">FINANCIAL OVERVIEW</p>
            <h1>Analysis</h1>
            <p>Understand your cash flow, monthly budget, and spending patterns.</p>
        </div>

        <div class="analysis-summary">
            <div class="analysis-stat income-stat"><span>Total Income</span><strong>Rp {{ number_format($income, 0, ',', '.') }}</strong></div>
            <div class="analysis-stat expense-stat"><span>Total Expenses</span><strong>Rp {{ number_format($expense, 0, ',', '.') }}</strong></div>
            <div class="analysis-stat"><span>Budget This Month</span><strong>Rp {{ number_format($currentMonthBudget, 0, ',', '.') }}</strong></div>
            <div class="analysis-stat"><span>Budget Remaining</span><strong>Rp {{ number_format($remainingBudget, 0, ',', '.') }}</strong></div>
            <div class="analysis-stat"><span>Balance</span><strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong></div>
            <div class="analysis-stat"><span>Transactions</span><strong>{{ $transactionCount }}</strong></div>
            <div class="analysis-stat income-stat"><span>Income This Month</span><strong>Rp {{ number_format($currentMonthIncome, 0, ',', '.') }}</strong></div>
            <div class="analysis-stat expense-stat"><span>Expenses This Month</span><strong>Rp {{ number_format($currentMonthExpense, 0, ',', '.') }}</strong></div>
        </div>

        <div class="analysis-grid">
            <section class="analysis-panel">
                <h2>Income &amp; Expenses</h2>
                <div class="comparison-bars">
                    @php($maximumAmount = max($income, $expense, 1))
                    <div class="comparison-row">
                        <span>Income</span>
                        <div class="analysis-bar-track"><span class="income-bar" style="width: {{ min(100, ($income / $maximumAmount) * 100) }}%"></span></div>
                        <strong>Rp {{ number_format($income, 0, ',', '.') }}</strong>
                    </div>
                    <div class="comparison-row">
                        <span>Expenses</span>
                        <div class="analysis-bar-track"><span class="expense-bar" style="width: {{ min(100, ($expense / $maximumAmount) * 100) }}%"></span></div>
                        <strong>Rp {{ number_format($expense, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </section>

            <section class="analysis-panel">
                <h2>Spending by Category</h2>
                @if($expensesByCategory->isEmpty())
                    <p class="analysis-empty">No expense data yet. Add an expense to see your category breakdown.</p>
                @else
                    @php($highestAmount = max(1, $expensesByCategory->first()))
                    <p class="analysis-highlight">Top spending category: <strong>{{ $highestCategory }}</strong></p>
                    <div class="category-analysis-list">
                        @foreach($expensesByCategory as $categoryName => $amount)
                            <div class="category-analysis-item">
                                <div><span>{{ $categoryName }}</span><strong>Rp {{ number_format($amount, 0, ',', '.') }}</strong></div>
                                <div class="analysis-bar-track"><span class="expense-bar" style="width: {{ min(100, ($amount / $highestAmount) * 100) }}%"></span></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <section class="analysis-panel monthly-analysis">
            <h2>Six-Month Summary</h2>
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
                            <span class="income">Rp {{ number_format($summary['income'], 0, ',', '.') }}</span>
                            <span class="expense">Rp {{ number_format($summary['expense'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="analysis-legend"><span class="legend-income"></span> Income <span class="legend-expense"></span> Expenses</p>
        </section>

        <section class="analysis-panel recent-analysis">
            <h2>Recent Transactions</h2>
            @forelse($recentTransactions as $transaction)
                <div class="analysis-recent-item">
                    <div>
                        <strong>{{ $transaction->description }}</strong>
                        <span>{{ $transaction->category?->name ?? 'Uncategorized' }} · {{ $transaction->date }}</span>
                    </div>
                    <strong class="{{ $transaction->type === 'pemasukan' ? 'income' : 'expense' }}">
                        {{ $transaction->type === 'pemasukan' ? '+' : '−' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </strong>
                </div>
            @empty
                <p class="analysis-empty">No transactions yet. Add a transaction to see your recent activity.</p>
            @endforelse
        </section>

        <section class="analysis-panel ai-analysis-panel">
            <div class="ai-analysis-heading">
                <div>
                    <p class="small-title">PERSONALIZED INSIGHTS</p>
                    <h2>AI-Generated Insights</h2>
                </div>
                <form action="{{ route('analysis.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-button">Generate Analysis</button>
                </form>
            </div>

            @include('partials.ui-alerts', ['alertClass' => 'ai-message'])

            @if($aiAnalysis)
                <div class="ai-analysis-result">{!! nl2br(e($aiAnalysis)) !!}</div>
            @else
                <p class="analysis-empty">Generate a concise review of your spending, budget, and savings habits based on your account summary.</p>
            @endif
        </section>

        <a href="{{ route('dashboard') }}" class="button secondary">Back to Dashboard</a>
    </div>
</section>
@endsection
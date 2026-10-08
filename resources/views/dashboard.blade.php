
@extends('layout')

@section('title', 'Dashboard - Pockettivity')

@section('content')

<section class="dashboard">

    <div class="dashboard-container">

        <p class="small-title">DASHBOARD</p>

        <h1>
            Welcome, {{ Auth::user()->name }}
        </h1>

        <p>
            Your finances, all in one place.
        </p>


        <div class="dashboard-menu">

            <a href="{{ route('transactions') }}" class="dashboard-feature">

                <div class="feature-icon">
                    +
                </div>

                <div>
                    <h3>
                        Record Transactions
                    </h3>

                    <p>
                        Add and review income and expenses.
                    </p>
                </div>

            </a>


            <a href="{{ route('analysis') }}" class="dashboard-feature">

                <div class="feature-icon">
                    ↗
                </div>

                <div>
                    <h3>
                        Reports & Analysis
                    </h3>

                    <p>
                        Understand your spending and cash flow.
                    </p>
                </div>

            </a>


            <a href="{{ route('budgets') }}" class="dashboard-feature">

                <div class="feature-icon">
                    Rp
                </div>

                <div>
                    <h3>
                        Budget Management
                    </h3>

                    <p>
                        Set monthly limits and track your progress.
                    </p>
                </div>

            </a>

        </div>


        <div class="dashboard-card">

            <h3>
                Financial Summary
            </h3>


            <div class="money-summary">


                <div>

                    <span>
                        Income
                    </span>

                    <strong>
                        Rp {{ number_format($income, 0, ',', '.') }}
                    </strong>

                </div>


                <div>

                    <span>
                        Expenses
                    </span>

                    <strong>
                        Rp {{ number_format($expense, 0, ',', '.') }}
                    </strong>

                </div>


                <div>

                    <span>
                        Balance
                    </span>

                    <strong>
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </strong>

                </div>


                <div>
                    <span>Budget remaining this month</span>
                    <strong>Rp {{ number_format($budgetRemaining, 0, ',', '.') }}</strong>
                </div>


            </div>

        </div>

        <div class="dashboard-quick-actions">
            <a href="{{ route('transactions', ['new_type' => 'pemasukan']) }}#transaction-entry" class="button primary">+ Add Income</a>
            <a href="{{ route('transactions', ['new_type' => 'pengeluaran']) }}#transaction-entry" class="button expense-action">− Add Expense</a>
        </div>

        <div class="dashboard-card recent-transactions">
            <div class="recent-transactions-heading">
                <h3>Recent Transactions</h3>
                <a href="{{ route('transactions') }}">View All Transactions</a>
            </div>

            @forelse($latestTransactions as $transaction)
                <div class="recent-transaction-item">
                    <div>
                        <strong>{{ $transaction->description }}</strong>
                        <span>{{ $transaction->category?->name ?? 'Uncategorized' }} · {{ $transaction->date }}</span>
                    </div>
                    <strong class="{{ $transaction->type === 'pemasukan' ? 'income' : 'expense' }}">
                        {{ $transaction->type === 'pemasukan' ? '+' : '−' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </strong>
                </div>
            @empty
                <p>No transactions yet. Add your first transaction to see it here.</p>
            @endforelse
        </div>
    </div>

</section>

@endsection


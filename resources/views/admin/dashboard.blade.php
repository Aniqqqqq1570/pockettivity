
@extends('layout')

@section('title', 'Admin Dashboard | Pockettivity')

@section('content')

<section class="dashboard">

    <div class="dashboard-container">

        <div class="admin-header">

            <p class="small-title">
                ADMIN PANEL
            </p>

            <h1>
                Admin Dashboard
            </h1>

            <p>
                Welcome, {{ Auth::user()->name }}.
            </p>

        </div>


        <nav class="admin-shortcuts" aria-label="Admin shortcuts">

            <a
                href="{{ route('admin.users') }}"
                class="admin-shortcut-link"
            >
                User Management
            </a>

            <a href="{{ route('admin.transactions') }}" class="admin-shortcut-link">
                Transactions
            </a>

        </nav>


        <div class="admin-statistics">

            <div class="admin-stat-card">

                <div class="stat-icon">
                    U
                </div>

                <div>
                    <span>
                        Total Users
                    </span>

                    <h2>
                        {{ $users }}
                    </h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon">
                    A
                </div>

                <div>
                    <span>Total Admins</span>
                    <h2>{{ $admins }}</h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon">
                    U
                </div>

                <div>
                    <span>Standard Users</span>
                    <h2>{{ $normalUsers }}</h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon">
                    T
                </div>

                <div>
                    <span>
                        Total Transactions
                    </span>

                    <h2>
                        {{ $transactions }}
                    </h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon income-icon">
                    +
                </div>

                <div>
                    <span>
                        Total Income
                    </span>

                    <h2>
                        Rp {{ number_format($income, 0, ',', '.') }}
                    </h2>
                </div>

            </div>


            <div class="admin-stat-card">

                <div class="stat-icon expense-icon">
                    −
                </div>

                <div>
                    <span>
                        Total Expenses
                    </span>

                    <h2>
                        Rp {{ number_format($expense, 0, ',', '.') }}
                    </h2>
                </div>

            </div>

        </div>


        <div class="admin-transactions">

            <div class="admin-section-header">

                <div>

                    <h3>
                        Recent Transactions
                    </h3>

                    <p>
                        Latest activity across all accounts.
                    </p>

                </div>

            </div>


            @if($transactionList->count() > 0)

                <div class="admin-transaction-list">

                    @foreach($transactionList as $transaction)

                        <div class="admin-transaction-item">

                            <div class="transaction-user-avatar">
                                {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                            </div>


                            <div class="admin-transaction-info">

                                <strong>
                                    {{ $transaction->description }}
                                </strong>

                                <span>
                                    {{ $transaction->user->name }}
                                </span>

                                <span>
                                    {{ $transaction->category?->name ?? 'Uncategorized' }}
                                </span>

                                <small>
                                    {{ $transaction->date }}
                                </small>

                            </div>

                            <div class="admin-transaction-amount">

                                @if($transaction->type == 'pemasukan')

                                    <strong class="admin-income">
                                        + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </strong>

                                @else

                                    <strong class="admin-expense">
                                        - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </strong>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty-transactions">

                    <p>
                        No transactions yet.
                    </p>

                </div>

            @endif

        </div>

        <div class="admin-shortcuts">
            <a href="{{ route('admin.transactions') }}" class="admin-shortcut-link">
                View all transactions
            </a>
        </div>


        <form
            action="{{ route('logout') }}"
            method="POST"
            class="admin-logout"
        >

            @csrf

            <button
                type="submit"
                class="logout-button"
            >
                Log Out
            </button>

        </form>

    </div>

</section>

@endsection


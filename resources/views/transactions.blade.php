
@extends('layout')

@section('title', 'Transactions | Pockettivity')

@section('content')

<section class="transaction-page">

    <div class="transaction-container">

        <div class="transaction-header">

            <div>

                <p class="small-title">
                    TRANSACTIONS
                </p>

                <h1>
                    Transactions
                </h1>

                <p>
                    Record and review your income and expenses in one place.
                </p>

            </div>

        </div>


        <form action="{{ route('transactions') }}" method="GET" class="transaction-filter-form">
            <div>
                <label for="search">Search description</label>
                <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search transactions">
            </div>
            <div>
                <label for="filter_type">Type</label>
                <select id="filter_type" name="type">
                    <option value="">All types</option>
                    <option value="pemasukan" {{ ($filters['type'] ?? '') === 'pemasukan' ? 'selected' : '' }}>Income</option>
                    <option value="pengeluaran" {{ ($filters['type'] ?? '') === 'pengeluaran' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>
            <div>
                <label for="filter_category">Category</label>
                <select id="filter_category" name="category_id">
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date_from">From</label>
                <input id="date_from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
            </div>
            <div>
                <label for="date_to">To</label>
                <input id="date_to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
            </div>
            <div>
                <label for="sort">Sort by</label>
                <select id="sort" name="sort">
                    <option value="newest" {{ ($filters['sort'] ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="highest" {{ ($filters['sort'] ?? '') === 'highest' ? 'selected' : '' }}>Highest amount</option>
                    <option value="lowest" {{ ($filters['sort'] ?? '') === 'lowest' ? 'selected' : '' }}>Lowest amount</option>
                </select>
            </div>
            <div class="transaction-filter-actions">
                <button type="submit" class="transaction-button">Apply Filters</button>
                <a href="{{ route('transactions') }}" class="button secondary">Clear Filters</a>
            </div>
        </form>


        @php

            $income = $transactions
                ->where('type', 'pemasukan')
                ->sum('amount');

            $expense = $transactions
                ->where('type', 'pengeluaran')
                ->sum('amount');

            $balance = $income - $expense;

        @endphp


        <div class="transaction-summary">

            <div class="summary-box">

                <span>
                    Total Income
                </span>

                <h2>
                    Rp {{ number_format($income, 0, ',', '.') }}
                </h2>

            </div>


            <div class="summary-box">

                <span>
                    Total Expenses
                </span>

                <h2>
                    Rp {{ number_format($expense, 0, ',', '.') }}
                </h2>

            </div>


            <div class="summary-box">

                <span>
                    Balance
                </span>

                <h2>
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </h2>

            </div>

        </div>


        <div class="transaction-content">


            <div class="transaction-form dashboard-card" id="transaction-entry">

                <h3>
                    Add Transaction
                </h3>

                <p>
                    Add an income or expense record.
                </p>


                @include('partials.ui-alerts')


                <form
                    action="{{ route('transactions.store') }}"
                    method="POST"
                >

                    @csrf


                    <label>
                        Type
                    </label>

                    <select name="type" required>

                        <option value="pemasukan" {{ old('type', $defaultType) === 'pemasukan' ? 'selected' : '' }}>
                            Income
                        </option>

                        <option value="pengeluaran" {{ old('type', $defaultType) === 'pengeluaran' ? 'selected' : '' }}>
                            Expense
                        </option>

                    </select>

                    <label for="category_id">
                        Category
                    </label>

                    <select name="category_id" id="category_id" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @if($categories->isEmpty())
                        <p class="form-hint">
                            Create a category before adding transactions.
                            <a href="{{ route('categories') }}">Manage Categories</a>
                        </p>
                    @endif


                    <label>
                        Amount
                    </label>

                    <input
                        type="number"
                        name="amount"
                        placeholder="e.g. 500000"
                        required
                    >


                    <label>
                        Description
                    </label>

                    <input
                        type="text"
                        name="description"
                        placeholder="e.g. Salary, groceries, or transport"
                        required
                    >


                    <label>
                        Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        required
                    >


                    <button
                        type="submit"
                        class="transaction-button"
                    >
                        Add Transaction
                    </button>

                </form>

            </div>


            <div class="transaction-list dashboard-card">

                <div class="transaction-list-header">

                    <div>

                        <h3>
                            Transaction History
                        </h3>

                        <p>
                            Your recent activity
                        </p>

                    </div>

                </div>


                @if($transactions->count() > 0)

                    <div class="transaction-table">

                        @foreach($transactions as $transaction)

                            <div class="transaction-item">

                                <div class="transaction-icon">

                                    @if($transaction->type == 'pemasukan')

                                        +

                                    @else

                                        -

                                    @endif

                                </div>


                                <div class="transaction-info">

                                    <strong>
                                        {{ $transaction->description }}
                                    </strong>

                                    <span>
                                        {{ $transaction->date }}
                                    </span>

                                    <span class="transaction-category">
                                        {{ $transaction->category?->name ?? 'Uncategorized' }}
                                    </span>

                                </div>


                                <div class="transaction-amount">

                                    @if($transaction->type == 'pemasukan')

                                        <strong class="income">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </strong>

                                        <span class="income-label">
                                            Income
                                        </span>

                                    @else

                                        <strong class="expense">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </strong>

                                        <span class="expense-label">
                                            Expense
                                        </span>

                                    @endif

                                </div>


                                <a
                                    href="{{ route('transactions.edit', $transaction->id) }}"
                                    class="edit-button"
                                >
                                    Edit
                                </a>


                                <form
                                    action="{{ route('transactions.destroy', $transaction->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this transaction? This action cannot be undone.')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="delete-button"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="empty-transaction">

                        <div class="empty-icon">
                            Rp
                        </div>

                        <h4>
                            No transactions yet
                        </h4>

                        <p>
                            Add your first transaction using the form beside this history.
                        </p>
                        <a href="#transaction-entry" class="button primary">Add Transaction</a>

                    </div>

                @endif

            </div>

        </div>


        <a
            href="{{ route('features') }}"
            class="button secondary"
        >
            Back to Features
        </a>

        <a href="{{ route('categories') }}" class="button secondary">
            Manage Categories
        </a>

    </div>

</section>

@endsection


@extends('layout')

@section('title', 'All Transactions | Pockettivity')

@section('content')
<section class="dashboard">
    <div class="dashboard-container">
        <div class="admin-header">
            <p class="small-title">ADMIN PANEL</p>
            <h1>All Transactions</h1>
            <p>Review financial activity across all accounts.</p>
        </div>

        @include('partials.ui-alerts')

        <form action="{{ route('admin.transactions') }}" method="GET" class="admin-filter-form">
            <div>
                <label for="user_id">User</label>
                <select id="user_id" name="user_id">
                    <option value="">All users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="type">Type</label>
                <select id="type" name="type">
                    <option value="">All types</option>
                    <option value="pemasukan" {{ ($filters['type'] ?? '') === 'pemasukan' ? 'selected' : '' }}>Income</option>
                    <option value="pengeluaran" {{ ($filters['type'] ?? '') === 'pengeluaran' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>
            <div>
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }} · {{ $category->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date">Date</label>
                <input id="date" type="date" name="date" value="{{ $filters['date'] ?? '' }}">
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="admin-button">Apply Filters</button>
                <a href="{{ route('admin.transactions') }}" class="button secondary">Clear Filters</a>
            </div>
        </form>

        <div class="admin-transactions">
            <div class="admin-section-header">
                <h3>Transaction History</h3>
                <p>{{ $transactions->total() }} matching transactions</p>
            </div>

            @forelse($transactions as $transaction)
                <div class="admin-transaction-item">
                    <div class="transaction-user-avatar">{{ strtoupper(substr($transaction->user->name, 0, 1)) }}</div>
                    <div class="admin-transaction-info">
                        <strong>{{ $transaction->description }}</strong>
                        <span>{{ $transaction->user->name }} · {{ $transaction->category?->name ?? 'Uncategorized' }}</span>
                        <small>{{ $transaction->date }}</small>
                    </div>
                    <div class="admin-transaction-amount">
                        @if($transaction->type === 'pemasukan')
                            <strong class="admin-income">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</strong>
                        @else
                            <strong class="admin-expense">− Rp {{ number_format($transaction->amount, 0, ',', '.') }}</strong>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-transactions"><p>No transactions match these filters.</p></div>
            @endforelse
        </div>

        <div class="admin-pagination">{{ $transactions->links() }}</div>
        <a href="{{ route('admin.dashboard') }}" class="button secondary">Back to Dashboard</a>
    </div>
</section>
@endsection
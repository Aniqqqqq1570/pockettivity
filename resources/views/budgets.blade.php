@extends('layout')

@section('title', 'Budgets | Pockettivity')

@section('content')
@php
    $monthLabels = [
        'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March', 'April' => 'April',
        'Mei' => 'May', 'Juni' => 'June', 'Juli' => 'July', 'Agustus' => 'August',
        'September' => 'September', 'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December',
    ];
@endphp
<section class="transaction-page">
    <div class="transaction-container">
        <div class="transaction-header">
            <p class="small-title">MONTHLY PLANNING</p>
            <h1>Budgets</h1>
            <p>Set spending limits by category and track your progress throughout the month.</p>
        </div>

        @include('partials.ui-alerts', ['alertClass' => 'category-alert'])

        @if($categories->isEmpty())
            <div class="dashboard-card budget-empty">
                <h3>Create a category first</h3>
                <p>Budgets are organized by category. Add a category to get started.</p>
                <a href="{{ route('categories') }}" class="transaction-button">Manage Categories</a>
            </div>
        @else
            <div class="transaction-form dashboard-card budget-create" id="budget-create">
                <h3>Add Budget</h3>
                <form action="{{ route('budgets.store') }}" method="POST" class="budget-form">
                    @csrf
                    <div>
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="amount">Budget amount</label>
                        <input id="amount" type="number" name="amount" min="0.01" step="0.01" value="{{ old('amount') }}" required>
                    </div>
                    <div>
                        <label for="month">Month</label>
                        <select id="month" name="month" required>
                            @foreach($months as $number => $monthName)
                                <option value="{{ $number }}" {{ old('month', now()->month) == $number ? 'selected' : '' }}>{{ $monthLabels[$monthName] ?? $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="year">Year</label>
                        <input id="year" type="number" name="year" min="2000" max="2100" value="{{ old('year', now()->year) }}" required>
                    </div>
                    <button type="submit" class="transaction-button">Add Budget</button>
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
                            <p>{{ $monthLabels[$months[$budget->month]] ?? $months[$budget->month] }} {{ $budget->year }}</p>
                        </div>
                        <strong class="budget-status {{ $progressState }}">
                            @if($progressState === 'over') Over budget @elseif($progressState === 'near') Approaching limit @else Within limit @endif
                        </strong>
                    </div>

                    <div class="budget-numbers">
                        <span>Used <strong>Rp {{ number_format($budget->used, 0, ',', '.') }}</strong></span>
                        <span>Remaining <strong>Rp {{ number_format($remaining, 0, ',', '.') }}</strong></span>
                        <span>Budget <strong>Rp {{ number_format($budget->amount, 0, ',', '.') }}</strong></span>
                    </div>

                    <div class="budget-progress-track" role="progressbar" aria-label="{{ $budget->category->name }} budget usage" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ min(100, $percentage) }}">
                        <span class="{{ $progressState }}" style="width: {{ min(100, $percentage) }}%"></span>
                    </div>
                    <p class="budget-percent">{{ $percentage }}% used</p>

                    <details class="budget-edit">
                        <summary>Edit Budget</summary>
                        <form action="{{ route('budgets.update', $budget) }}" method="POST" class="budget-form">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="category-{{ $budget->id }}">Category</label>
                                <select id="category-{{ $budget->id }}" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $budget->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="amount-{{ $budget->id }}">Budget amount</label>
                                <input id="amount-{{ $budget->id }}" type="number" name="amount" min="0.01" step="0.01" value="{{ $budget->amount }}" required>
                            </div>
                            <div>
                                <label for="month-{{ $budget->id }}">Month</label>
                                <select id="month-{{ $budget->id }}" name="month" required>
                                    @foreach($months as $number => $monthName)
                                        <option value="{{ $number }}" {{ $budget->month == $number ? 'selected' : '' }}>{{ $monthLabels[$monthName] ?? $monthName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="year-{{ $budget->id }}">Year</label>
                                <input id="year-{{ $budget->id }}" type="number" name="year" min="2000" max="2100" value="{{ $budget->year }}" required>
                            </div>
                            <button type="submit" class="transaction-button">Save Changes</button>
                        </form>
                    </details>

                    <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Delete this budget? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </article>
            @empty
                <div class="empty-transaction dashboard-card">
                    <h4>No budgets yet</h4>
                    <p>Add a budget to start tracking monthly spending.</p>
                    <a href="#budget-create" class="button primary">Add Budget</a>
                </div>
            @endforelse
        </div>

        <a href="{{ route('dashboard') }}" class="button secondary">Back to Dashboard</a>
    </div>
</section>
@endsection
@extends('layout')

@section('title', 'Categories | Pockettivity')

@section('content')
<section class="transaction-page category-page">
    <div class="transaction-container">
        <div class="transaction-header">
            <p class="small-title">CATEGORY MANAGEMENT</p>
            <h1>Categories</h1>
            <p>Organize income and expenses with categories that work for you.</p>
        </div>

        @include('partials.ui-alerts', ['alertClass' => 'category-alert'])

        <div class="category-layout">
            <div class="transaction-form dashboard-card" id="category-create">
                <h3>Add Category</h3>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <label for="name">Category name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" maxlength="100" required>
                    <button type="submit" class="transaction-button">Add Category</button>
                </form>
            </div>

            <div class="category-list dashboard-card">
                <h3>Your Categories</h3>
                @forelse($categories as $category)
                    <div class="category-item">
                        <form action="{{ route('categories.update', $category) }}" method="POST" class="category-edit-form">
                            @csrf
                            @method('PUT')
                            <label class="visually-hidden" for="category-{{ $category->id }}">Category name</label>
                            <input id="category-{{ $category->id }}" type="text" name="name" value="{{ $category->name }}" maxlength="100" required>
                            <button type="submit" class="edit-button">Save Changes</button>
                        </form>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category? Transactions using it will become uncategorized.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </div>
                @empty
                    <div class="empty-transaction">
                        <h4>No categories yet</h4>
                        <p>Add a category to organize your transactions.</p>
                        <a href="#category-create" class="button primary">Add Category</a>
                    </div>
                @endforelse
            </div>
        </div>

        <a href="{{ route('transactions') }}" class="button secondary">Back to Transactions</a>
    </div>
</section>
@endsection
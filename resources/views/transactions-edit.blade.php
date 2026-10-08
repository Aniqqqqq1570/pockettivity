
@extends('layout')

@section('title', 'Edit Transaction | Pockettivity')

@section('content')

<section class="transaction-page">

    <div class="transaction-container">

        <div class="transaction-form dashboard-card">

            <p class="small-title">
                EDIT TRANSACTION
            </p>

            <h1>
                Edit Transaction
            </h1>

            <p>
                Update the details for this transaction.
            </p>


            @include('partials.ui-alerts')


            <form
                action="{{ route('transactions.update', $transaction->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <label>
                    Type
                </label>

                <select name="type" required>

                    <option
                        value="pemasukan"
                        {{ $transaction->type == 'pemasukan' ? 'selected' : '' }}
                    >
                        Income
                    </option>

                    <option
                        value="pengeluaran"
                        {{ $transaction->type == 'pengeluaran' ? 'selected' : '' }}
                    >
                        Expense
                    </option>

                </select>

                <label for="category_id">
                    Category
                </label>

                <select name="category_id" id="category_id" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @if($categories->isEmpty())
                    <p class="form-hint">
                        Create a category before editing this transaction.
                        <a href="{{ route('categories') }}">Manage Categories</a>
                    </p>
                @endif


                <label>
                    Amount
                </label>

                <input
                    type="number"
                    name="amount"
                    value="{{ $transaction->amount }}"
                    required
                >


                <label>
                    Description
                </label>

                <input
                    type="text"
                    name="description"
                    value="{{ $transaction->description }}"
                    required
                >


                <label>
                    Date
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ $transaction->date }}"
                    required
                >


                <button
                    type="submit"
                    class="transaction-button"
                >
                    Save Changes
                </button>

            </form>


            <br>


            <a
                href="{{ route('transactions') }}"
                class="button secondary"
            >
                Cancel
            </a>

        </div>

    </div>

</section>

@endsection


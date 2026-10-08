@extends('layout')

@section('title', 'Pockettivity Features')

@section('content')

<section class="features-page">

    <div class="features-container">

        <p class="small-title">
            POCKETTIVITY FEATURES
        </p>

        <h1>
            Tools for everyday finances
        </h1>

        <p class="features-description">
            Keep your records organized, monitor your budget, and understand your financial activity.
        </p>


        <div class="features-list">

            <a href="{{ route('transactions') }}" class="feature-card">

                <div class="icon">
                    +
                </div>

                <h3>
                    Transaction Recording
                </h3>

                <p>
                    Record income and expenses in one searchable history.
                </p>

            </a>


            <a href="{{ route('analysis') }}" class="feature-card">

                <div class="icon">
                    ↗
                </div>

                <h3>
                    Reports & Analysis
                </h3>

                <p>
                    Review your cash flow, monthly activity, and spending by category.
                </p>

            </a>


            <a href="{{ route('categories') }}" class="feature-card">

                <div class="icon">
                    Rp
                </div>

                <h3>
                    Categories
                </h3>

                <p>
                    Organize transactions with categories that work for you.
                </p>

            </a>

            <a href="{{ route('budgets') }}" class="feature-card">
                <div class="icon">Rp</div>
                <h3>Budget Management</h3>
                <p>Set monthly spending limits by category and track your progress.</p>
            </a>

            <a href="{{ route('transactions') }}" class="feature-card">
                <div class="icon">≡</div>
                <h3>Transaction History</h3>
                <p>Search, filter, and sort your financial records.</p>
            </a>

            <a href="{{ route('dashboard') }}" class="feature-card">
                <div class="icon">✓</div>
                <h3>Financial Summary</h3>
                <p>See income, expenses, balance, and remaining budget at a glance.</p>
            </a>

        </div>


        <a href="{{ route('home') }}" class="button primary">
            Back to Home
        </a>

    </div>

</section>

@endsection
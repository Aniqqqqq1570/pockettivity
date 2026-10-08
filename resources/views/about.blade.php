@extends('layout')

@section('title', 'About Pockettivity')

@section('content')

<section class="about-page">

    <div class="about-container">

        <p class="small-title">
            ABOUT POCKETTIVITY
        </p>

        <h1>
            Personal finance, made clearer
        </h1>

        <p>
            Pockettivity helps you keep your personal finances organized in one simple workspace.
        </p>

        <p>
            Record income and expenses, organize transactions by category, set monthly budgets, and understand your spending over time.
        </p>

        <div class="about-card">

            <h2>
                Our purpose
            </h2>

            <p>
                Make everyday money management easier to follow, so you can make informed choices with a clearer view of your finances.
            </p>

        </div>

        <div class="about-card">
            <h2>Why track your finances?</h2>
            <p>Consistent records help you understand spending patterns, plan for monthly needs, and set priorities based on your actual activity.</p>
            <p>Pockettivity brings transactions, categories, budgets, and summaries together in one clear view.</p>
        </div>

        <a href="{{ route('home') }}" class="button primary">
            Back to Home
        </a>

    </div>

</section>

@endsection
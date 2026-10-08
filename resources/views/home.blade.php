@extends('layout')

@section('title', 'Pockettivity | Money, Made Clear')

@section('content')

<section class="hero">

    <div class="hero-content">
        <div class="hero-copy">
            <p class="small-title">PERSONAL FINANCE, MADE CLEAR</p>
            <h1>Manage your money with <strong>pockettivity</strong></h1>
            <p class="hero-text">
                A calmer way to keep track of what comes in, what goes out, and what you want to save. Make everyday money decisions with a clearer picture.
            </p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="button primary">Open dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="button primary">Get started</a>
                @endauth
                <a href="{{ route('features') }}" class="button secondary">Explore features</a>
            </div>
            <p class="hero-platform-note"><span></span> Your personal finance workspace on the web</p>
        </div>

        <div class="hero-visual" role="img" aria-label="Pockettivity financial workspace with transaction, budget, and spending tools">
            <div class="app-showcase">
                <div class="app-showcase-top">
                    <span>Pockettivity workspace</span>
                    <span class="showcase-status">Ready for you</span>
                </div>
                <div class="app-showcase-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="">
                    <div>
                        <strong>pockettivity</strong>
                        <span>Personal finance, in focus</span>
                    </div>
                </div>
                <div class="showcase-points">
                    <div class="showcase-point">Record every transaction</div>
                    <div class="showcase-point">Plan a monthly budget</div>
                    <div class="showcase-point">See where your money goes</div>
                </div>
                <div class="app-showcase-footer">
                    <span>One clear view of your finances</span>
                    <strong>POCKETTIVITY</strong>
                </div>
            </div>
        </div>

    </div>

</section>


<section class="features home-features">

    <div class="features-container">
        <p class="small-title">A LITTLE MORE CLARITY, EVERY DAY</p>
        <h2>Your money, thoughtfully organized</h2>

        <div class="features-list">
            <a href="{{ route('transactions') }}" class="feature-card">
                <div class="icon">+</div>
                <h3>Transaction recording</h3>
                <p>Keep income and expenses together in a simple, searchable history.</p>
            </a>
            <a href="{{ route('analysis') }}" class="feature-card">
                <div class="icon">↗</div>
                <h3>Reports and analysis</h3>
                <p>Understand monthly activity and see which categories shape your spending.</p>
            </a>
            <a href="{{ route('budgets') }}" class="feature-card">
                <div class="icon">Rp</div>
                <h3>Budget management</h3>
                <p>Set a monthly limit and follow your progress as the month unfolds.</p>
            </a>
        </div>

        <div class="about-card home-explanation">
            <h2>Small habits. A clearer picture.</h2>
            <p>Log a transaction, give it a category, and let your dashboard bring the month into view. Pockettivity keeps the routine straightforward so you can focus on the choices that matter to you.</p>
        </div>
    </div>

</section>


<section class="start-section">

    <div>

        <h2>
            Ready to feel more in control?
        </h2>

        <p>
            Start with one small step: bring your everyday finances into focus.
        </p>

        @auth
            <a href="{{ route('dashboard') }}" class="button primary">Open dashboard</a>
        @else
            <a href="{{ route('register') }}" class="button primary">Create your account</a>
        @endauth

    </div>

</section>

@endsection
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Pockettivity')
    </title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pockettivity-theme.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

</head>

<body class="{{ request()->routeIs('login', 'register') ? 'auth-shell' : (request()->routeIs('home', 'about', 'features') ? 'public-shell' : 'app-shell') }}">

    <header class="navbar">

        <div class="nav-container">

            <a href="{{ route('home') }}" class="logo">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt=""
                >
                <span>pockettivity</span>
            </a>

            <input type="checkbox" class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation">
            <label class="nav-toggle-label" for="nav-toggle">
                <span></span>
                <span></span>
                <span class="visually-hidden">Toggle navigation</span>
            </label>

            <div class="nav-menu">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a class="{{ request()->routeIs('admin.dashboard') ? 'is-current' : '' }}" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                        <a class="{{ request()->routeIs('admin.users') ? 'is-current' : '' }}" href="{{ route('admin.users') }}">User Management</a>
                        <a class="{{ request()->routeIs('admin.transactions') ? 'is-current' : '' }}" href="{{ route('admin.transactions') }}">Transactions</a>
                    @else
                        <a class="{{ request()->routeIs('dashboard') ? 'is-current' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        <a class="{{ request()->routeIs('transactions*') ? 'is-current' : '' }}" href="{{ route('transactions') }}">Transactions</a>
                        <a class="{{ request()->routeIs('categories*') ? 'is-current' : '' }}" href="{{ route('categories') }}">Categories</a>
                        <a class="{{ request()->routeIs('analysis') ? 'is-current' : '' }}" href="{{ route('analysis') }}">Analysis</a>
                        <a class="{{ request()->routeIs('budgets*') ? 'is-current' : '' }}" href="{{ route('budgets') }}">Budgets</a>
                    @endif
                    <a class="nav-profile {{ request()->routeIs('profile*') ? 'is-current' : '' }}" href="{{ route('profile') }}">Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-login-button nav-logout-button">Log Out</button>
                    </form>
                @else
                    <a class="{{ request()->routeIs('home') ? 'is-current' : '' }}" href="{{ route('home') }}">Home</a>
                    <a class="{{ request()->routeIs('about') ? 'is-current' : '' }}" href="{{ route('about') }}">About</a>
                    <a class="{{ request()->routeIs('features') ? 'is-current' : '' }}" href="{{ route('features') }}">Features</a>
                    <a href="{{ route('login') }}" class="nav-login-button">Log In</a>
                @endauth
            </div>

        </div>

    </header>


    @yield('content')


    <footer>
        <p>Copyright © Pockettivity</p>
    </footer>

</body>

</html>
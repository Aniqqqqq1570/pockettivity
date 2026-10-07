<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Pockettivity')
    </title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    <nav class="navbar">

        <div class="nav-container">

            <a href="{{ route('home') }}" class="logo">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Pockettivity"
                >

                <span>
                    Pockettivity
                </span>

            </a>

            <div class="nav-menu">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <a href="{{ route('about') }}">
                    Tentang
                </a>

                <a href="{{ route('features') }}">
                    Fitur
                </a>

                <a href="{{ route('login') }}" class="login-button">
                    Login
                </a>

            </div>

        </div>

    </nav>


    @yield('content')


    <footer>

        <p>
            © 2026 Pockettivity. All rights reserved.
        </p>

    </footer>

</body>

</html>
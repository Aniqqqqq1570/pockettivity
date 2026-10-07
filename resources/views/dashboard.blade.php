@extends('layout')

@section('title', 'Dashboard - Pockettivity')

@section('content')

<section class="dashboard">

```
<div class="dashboard-container">

    <p class="small-title">
        DASHBOARD
    </p>

    <h1>
        Selamat datang, {{ Auth::user()->name }}
    </h1>

    <p>
        Kelola keuanganmu dengan Pockettivity.
    </p>


    <div class="dashboard-menu">

        <a href="{{ route('transactions') }}" class="dashboard-feature">

            <div class="feature-icon">
                +
            </div>

            <div>
                <h3>
                    Transaction Recording
                </h3>

                <p>
                    Catat pemasukan dan pengeluaran.
                </p>
            </div>

        </a>


        <a href="#" class="dashboard-feature">

            <div class="feature-icon">
                ↗
            </div>

            <div>
                <h3>
                    Money Analysis
                </h3>

                <p>
                    Lihat kondisi dan ringkasan keuangan.
                </p>
            </div>

        </a>


        <a href="#" class="dashboard-feature">

            <div class="feature-icon">
                Rp
            </div>

            <div>
                <h3>
                    Budget Management
                </h3>

                <p>
                    Atur dan pantau budget keuangan.
                </p>

            </div>

        </a>

    </div>


    <div class="dashboard-card">

        <h3>
            Ringkasan Keuangan
        </h3>

        <div class="money-summary">

            <div>
                <span>
                    Pemasukan
                </span>

                <strong>
                    Rp 0
                </strong>
            </div>

            <div>
                <span>
                    Pengeluaran
                </span>

                <strong>
                    Rp 0
                </strong>
            </div>

            <div>
                <span>
                    Saldo
                </span>

                <strong>
                    Rp 0
                </strong>
            </div>

        </div>

    </div>


    <form action="{{ route('logout') }}" method="POST">

        @csrf

        <button class="logout-button" type="submit">
            Logout
        </button>

    </form>

</div>
```

</section>

@endsection

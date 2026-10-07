@extends('layout')

@section('title', 'Transaction Recording - Pockettivity')

@section('content')

<section class="dashboard">

```
<div class="dashboard-container">

    <p class="small-title">
        TRANSACTION RECORDING
    </p>

    <h1>
        Catat Transaksi
    </h1>

    <p>
        Catat pemasukan dan pengeluaran keuanganmu.
    </p>


    <div class="dashboard-card">

        <h3>
            Tambah Transaksi
        </h3>

        @if(session('success'))

            <p style="color: green;">
                {{ session('success') }}
            </p>

        @endif

        @if($errors->any())

            <p style="color: red;">
                {{ $errors->first() }}
            </p>

        @endif


        <form action="{{ route('transactions.store') }}" method="POST">

            @csrf

            <label>
                Jenis Transaksi
            </label>

            <select name="type" required>
                <option value="pemasukan">
                    Pemasukan
                </option>

                <option value="pengeluaran">
                    Pengeluaran
                </option>
            </select>


            <label>
                Nominal
            </label>

            <input
                type="number"
                name="amount"
                placeholder="Masukkan nominal"
                required
            >


            <label>
                Keterangan
            </label>

            <input
                type="text"
                name="description"
                placeholder="Contoh: Gaji, makan, transportasi"
                required
            >


            <label>
                Tanggal
            </label>

            <input
                type="date"
                name="date"
                required
            >


            <button
                type="submit"
                class="logout-button"
            >
                Simpan Transaksi
            </button>

        </form>

    </div>


    <a
        href="{{ route('features') }}"
        class="button secondary"
    >
        Kembali ke Fitur
    </a>

</div>
```

</section>

@endsection

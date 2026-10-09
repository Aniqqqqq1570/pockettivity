
@extends('layout')

@section('title', 'Ubah Transaksi | Pockettivity')

@section('content')

<section class="transaction-page">

    <div class="transaction-container">

        <div class="transaction-form dashboard-card">

            <p class="small-title">
                UBAH TRANSAKSI
            </p>

            <h1>
                Ubah Transaksi
            </h1>

            <p>
                Perbarui detail transaksi ini.
            </p>


            @include('partials.ui-alerts')


            <form
                action="{{ route('transactions.update', $transaction->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <label>
                    Jenis
                </label>

                <select name="type" required>

                    <option
                        value="pemasukan"
                        {{ $transaction->type == 'pemasukan' ? 'selected' : '' }}
                    >
                        Pemasukan
                    </option>

                    <option
                        value="pengeluaran"
                        {{ $transaction->type == 'pengeluaran' ? 'selected' : '' }}
                    >
                        Pengeluaran
                    </option>

                </select>

                <label for="category_id">
                    Kategori
                </label>

                <select name="category_id" id="category_id" required>
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @if($categories->isEmpty())
                    <p class="form-hint">
                        Buat kategori sebelum mengubah transaksi ini.
                        <a href="{{ route('categories') }}">Kelola Kategori</a>
                    </p>
                @endif


                <label for="transaction-amount">
                    Nominal
                </label>

                <input
                    id="transaction-amount"
                    type="text"
                    name="amount"
                    data-money-input
                    data-money-min="0.01"
                    value="{{ \App\Support\MoneyFormatter::forInput(old('amount', $transaction->amount)) }}"
                    autocomplete="off"
                    required
                >


                <label>
                    Keterangan
                </label>

                <input
                    type="text"
                    name="description"
                    value="{{ $transaction->description }}"
                    required
                >


                <label>
                    Tanggal
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
                    Simpan Perubahan
                </button>

            </form>


            <br>


            <a
                href="{{ route('transactions') }}"
                class="button secondary"
            >
                Batal
            </a>

        </div>

    </div>

</section>

@endsection


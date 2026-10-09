@extends('layout')

@section('title', 'Profil | Pockettivity')

@section('content')
<section class="transaction-page">
    <div class="transaction-container profile-container">
        <div class="transaction-header">
            <p class="small-title">PENGATURAN AKUN</p>
            <h1>Profil</h1>
            <p>Perbarui informasi akun dan kata sandi Anda.</p>
        </div>

        @include('partials.ui-alerts', ['alertClass' => 'profile-alert'])

        <div class="profile-grid">
            <section class="dashboard-card profile-panel">
                <h2>Account Details</h2>
                <p class="profile-role">Peran: <strong>{{ $user->role === 'admin' ? 'Admin' : 'Pengguna' }}</strong></p>
                <form action="{{ route('profile.update') }}" method="POST" class="transaction-form">
                    @csrf
                    @method('PUT')
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    <label for="email">Alamat email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    <button type="submit" class="transaction-button">Simpan Perubahan</button>
                </form>
            </section>

            <section class="dashboard-card profile-panel">
                <h2>Change Password</h2>
                <form action="{{ route('profile.password') }}" method="POST" class="transaction-form">
                    @csrf
                    @method('PUT')
                    <label for="current_password">Kata sandi saat ini</label>
                    <input id="current_password" type="password" name="current_password" autocomplete="current-password" required>
                    <label for="password">Kata sandi baru</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" required>
                    <label for="password_confirmation">Ulangi kata sandi baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                    <button type="submit" class="transaction-button">Simpan Kata Sandi</button>
                </form>
            </section>
        </div>

        <a href="{{ $user->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="button secondary">Kembali ke Dasbor</a>
    </div>
</section>
@endsection
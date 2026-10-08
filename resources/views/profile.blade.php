@extends('layout')

@section('title', 'Profile | Pockettivity')

@section('content')
<section class="transaction-page">
    <div class="transaction-container profile-container">
        <div class="transaction-header">
            <p class="small-title">ACCOUNT SETTINGS</p>
            <h1>Profile</h1>
            <p>Update your account details and password.</p>
        </div>

        @include('partials.ui-alerts', ['alertClass' => 'profile-alert'])

        <div class="profile-grid">
            <section class="dashboard-card profile-panel">
                <h2>Account Details</h2>
                <p class="profile-role">Role: <strong>{{ $user->role === 'admin' ? 'Admin' : 'Standard User' }}</strong></p>
                <form action="{{ route('profile.update') }}" method="POST" class="transaction-form">
                    @csrf
                    @method('PUT')
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    <button type="submit" class="transaction-button">Save Changes</button>
                </form>
            </section>

            <section class="dashboard-card profile-panel">
                <h2>Change Password</h2>
                <form action="{{ route('profile.password') }}" method="POST" class="transaction-form">
                    @csrf
                    @method('PUT')
                    <label for="current_password">Current password</label>
                    <input id="current_password" type="password" name="current_password" autocomplete="current-password" required>
                    <label for="password">New password</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" required>
                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                    <button type="submit" class="transaction-button">Update Password</button>
                </form>
            </section>
        </div>

        <a href="{{ $user->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="button secondary">Back to Dashboard</a>
    </div>
</section>
@endsection
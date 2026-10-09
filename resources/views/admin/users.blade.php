
@extends('layout')

@section('title', 'Kelola Pengguna | Pockettivity')

@section('content')

<section class="dashboard">

    <div class="dashboard-container">

        <div class="admin-header">

            <div>

                <p class="small-title">
                    PANEL ADMIN
                </p>

                <h1>
                    Kelola Pengguna
                </h1>

                <p>
                    Kelola akun Pockettivity dan hak akses pengguna.
                </p>

            </div>

        </div>

        @include('partials.ui-alerts')

        <div class="user-list-card">

            <div class="user-list-header">

                <div>

                    <h3>
                        Pengguna
                    </h3>

                    <p>
                        {{ $users->count() }} akun terdaftar
                    </p>

                </div>

            </div>

            <div class="user-list">

                @foreach($users as $user)

                    <div class="user-item">

                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="user-info">

                            <strong>
                                {{ $user->name }}
                            </strong>

                            <span>
                                {{ $user->email }}
                            </span>

                        </div>

                        <div class="user-role">

                            @if($user->role == 'admin')

                                <span class="role-badge admin">
                                    Admin
                                </span>

                            @else

                                <span class="role-badge user">
                                    Pengguna
                                </span>

                            @endif

                        </div>

                        <div class="user-action">

                            @if($user->role == 'admin')

                                @if($user->id != Auth::id())

                                    <form
                                        action="{{ route('admin.users.makeUser', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin mengubah peran admin ini menjadi pengguna?')"
                                    >

                                        @csrf

                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="role-button secondary-role"
                                            aria-label="Jadikan {{ $user->name }} sebagai pengguna"
                                        >
                                            Jadikan Pengguna
                                        </button>

                                    </form>

                                @else

                                    <span class="current-user">
                                        Anda
                                    </span>

                                @endif

                            @else

                                <form
                                    action="{{ route('admin.users.makeAdmin', $user->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin memberikan peran admin kepada pengguna ini?')"
                                >

                                    @csrf

                                    @method('PUT')

                                    <button
                                        type="submit"
                                        class="role-button primary-role"
                                        aria-label="Jadikan {{ $user->name }} sebagai admin"
                                    >
                                        Jadikan Admin
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        <div class="admin-back">

            <a
                href="{{ route('admin.dashboard') }}"
                class="button secondary"
            >
                Kembali ke Dasbor
            </a>

        </div>

    </div>

</section>

@endsection



@extends('layout')

@section('title', 'User Management | Pockettivity')

@section('content')

<section class="dashboard">

    <div class="dashboard-container">

        <div class="admin-header">

            <div>

                <p class="small-title">
                    ADMIN PANEL
                </p>

                <h1>
                    User Management
                </h1>

                <p>
                    Manage Pockettivity accounts and access roles.
                </p>

            </div>

        </div>

        @include('partials.ui-alerts')

        <div class="user-list-card">

            <div class="user-list-header">

                <div>

                    <h3>
                        Users
                    </h3>

                    <p>
                        {{ $users->count() }} registered accounts
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
                                    Standard User
                                </span>

                            @endif

                        </div>

                        <div class="user-action">

                            @if($user->role == 'admin')

                                @if($user->id != Auth::id())

                                    <form
                                        action="{{ route('admin.users.makeUser', $user->id) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="role-button secondary-role"
                                        >
                                            Make Standard User
                                        </button>

                                    </form>

                                @else

                                    <span class="current-user">
                                        You
                                    </span>

                                @endif

                            @else

                                <form
                                    action="{{ route('admin.users.makeAdmin', $user->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('PUT')

                                    <button
                                        type="submit"
                                        class="role-button primary-role"
                                    >
                                        Make Admin
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
                Back to Dashboard
            </a>

        </div>

    </div>

</section>

@endsection


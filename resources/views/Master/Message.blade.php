<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noah's Ark</title>

    @include('Master.StyleMessage')

</head>

<body>
    <aside class="sidebar">
        <h2>Noah's Ark Admin</h2>
        <nav>
                <a href="{{ url('home') }}" >
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ url('admins') }}">
                    <i class="fas fa-user-shield"></i> Admins
                </a>
                <a href="{{ url('users') }}">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="{{ url('master-messenger') }}" class="active">
                    <i class="fas fa-comments"></i> Messages
                </a>
            </nav>
    </aside>
    <main class="main-content">
        <header class="header">
            <h1>Messenger</h1>
            @if(Route::has('login'))
            @auth
            <x-app-layout></x-app-layout>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
            @endauth
            @endif
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <main class="main-content">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">

                                @include('Chatify::pages.app')

                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </section>
    </main>

</body>

</html>
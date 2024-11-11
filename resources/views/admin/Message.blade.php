<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noah's Ark</title>

   


    @include('admin.StyleMessage')

</head>

<body>
    <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
            <nav>
                <a href="{{ url('home') }}" ><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('animal-profiles') }}"><i class="fas fa-paw"></i> Animals</a>
                <a href="{{ url('animal-locations') }}" ><i class="fas fa-map-marker-alt"></i> Animals Location</a>
                <a href="{{ url('adoption-requests') }}"><i class="fas fa-heart"></i> Adoption Requests</a>
                <a href="{{ url('reports') }}"><i class="fas fa-file-alt"></i> Reports</a>
                <a href="{{ url('approved-requests') }}"><i class="fas fa-check"></i> Create Meeting</a>
                <a href="{{ url('appointments') }}"><i class="fas fa-calendar-check"></i> Meeting Scheduled</a>
                <a href="{{ url('admin-messenger') }}" class="active"><i class="fas fa-comments"></i> Messages</a>

                <!-- Multi-Level Dropdown -->
                <div class="dropdown">
                    <button class="dropdown-btn"><i class="fas fa-folder-open"></i> Completed and Rejected</button>
                    <ul class="dropdown-content">
                        <li><a href="{{ url('completed-adoption') }}"><i class="fas fa-check-circle"></i> Completed Adoption Form</a></li>
                        <li><a href="{{ url('completed/Animal-Abuse-Report') }}"><i class="fas fa-exclamation-triangle"></i> Completed Report Form</a></li>

                        <ul class="dropdown-submenu">
                            <li><a href="{{ url('rejected-Form') }}"><i class="fas fa-times-circle"></i> Rejected Adoption Form</a></li>
                            <li><a href="{{ url('rejected') }}"><i class="fas fa-ban"></i> Rejected Report Form</a></li>
                        </ul>

                    </ul>
                </div>
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
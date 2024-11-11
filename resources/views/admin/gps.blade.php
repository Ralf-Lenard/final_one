<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.Headlinks')
    @include('admin.gpsStyle')
    

</head>

<body>

    <div class="wrapper">
        <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
            <nav>
                <a href="{{ url('home') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('animal-profiles') }}"><i class="fas fa-paw"></i> Animals</a>
                <a href="{{ url('animal-location') }}" class="active"><i class="fas fa-map-marker-alt"></i> Animals Location</a>
                <a href="{{ url('adoption-requests') }}"><i class="fas fa-heart"></i> Adoption Requests</a>
                <a href="{{ url('reports') }}"><i class="fas fa-file-alt"></i> Reports</a>
                <a href="{{ url('approved-requests') }}"><i class="fas fa-check"></i> Create Meeting</a>
                <a href="{{ url('appointments') }}"><i class="fas fa-calendar-check"></i> Meeting Scheduled</a>
                <a href="{{ url('admin-messenger') }}"><i class="fas fa-comments"></i> Messages</a>

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
                <h1>Animal Location</h1>
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
               
                    <iframe class="iframe"
                        src="https://www.sinotrack.com/"
                        width="100%"
                        height="600"
                        style="border: none;">
                    </iframe>
             

                </div>
            </section>


    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</body>

</html>
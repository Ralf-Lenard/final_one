<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    @include('Master.StyleForAll')
</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
            <h2>Noah's Ark Chief Admin</h2>
            <nav>
                <a href="{{ url('home') }}" class="active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ url('admins') }}">
                    <i class="fas fa-user-shield"></i> Admins
                </a>
                <a href="{{ url('users') }}">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="{{ url('master-messenger') }}">
                    <i class="fas fa-comments"></i> Messages
                </a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>Chief Admin Dashboard</h1>
                @if(Route::has('login'))
                @auth
                <x-app-layout></x-app-layout>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                @endauth
                @endif
            </header>
            <div class="container">
                <div class="card-grid">
                    <div class="card">
                        <div class="card-title">
                            <i class="fas fa-users"></i> Total Users
                        </div>
                        <div class="card-value" id="totalUsers">{{ $regularUsers }}</div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <i class="fas fa-user-shield"></i> Total Admins
                        </div>
                        <div class="card-value" id="totalAdmins">{{ $admins }}</div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <i class="fas fa-paw"></i> Total Animals
                        </div>
                        <div class="card-value" id="totalAnimals">{{ $totalAnimals }}</div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <i class="fas fa-flag"></i> Abuse Reports
                        </div>
                        <div class="card-value" id="abuseReports">{{ $abuseReport }}</div>
                    </div>
                    <div class="card">
                        <div class="card-title">
                            <i class="fas fa-heart"></i> Adoption
                        </div>
                        <div class="card-value" id="adoptionRequests">{{ $adoptionRequest }}</div>
                    </div>
                </div>


                <div class="chart-container">
                    <div class="chart">
                        <h2>Adoption Rate</h2>
                        <canvas id="adoptionRateChart"></canvas>
                    </div>
                    
                </div>


            </div>
        </main>
    </div>


    @include('Master.ScriptMaster')
</body>

</html>
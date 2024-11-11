<aside class="sidebar">
    <h2>Noah's Ark Admin</h2>
    <nav>
        <a href="{{url('home')}}" class="active">Dashboard</a>
        <!-- <a href="{{ url('users') }}">Users</a> -->
        <a href="{{ url('animal-profiles') }}">Animals</a>
        <a href="{{ url('adoption-requests') }}">Adoption Requests</a>
        <a href="{{ url('reports') }}">Reports</a>
        <a href="{{ url('approved-requests') }}">Messages</a>
        <a href="#">Settings</a>
    </nav>
</aside>
<main class="main-content">
    <header class="header">
        <h1>Dashboard</h1>
        @if(Route::has('login'))
        @auth
        <x-app-layout></x-app-layout>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
        @endauth
        @endif
    </header>
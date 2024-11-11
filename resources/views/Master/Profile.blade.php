<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Insert the provided CSS here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #4b5563;
        }

        .sidebar nav a {
            display: block;
            padding: 0.75rem 1rem;
            color: #4b5563;
            text-decoration: none;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            transition: background-color 0.3s;
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            background-color: #e5e7eb;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 250px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
        }

        .user-profile {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .user-profile-content {
            display: flex;
            padding: 2rem;
        }

        .user-profile-left {
            flex: 1;
            padding-right: 2rem;
            border-right: 1px solid #e5e7eb;
        }

        .user-profile-right {
            flex: 2;
            padding-left: 2rem;
            position: relative;
        }

        .user-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 2px solid #e5e7eb;
        }

        .user-info {
            margin-bottom: 1rem;
        }

        .user-info h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .user-info p {
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .personal-info h3 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .tt {
            margin-top: 50px;
            font-size: 1.25rem;
        }

        .info-item {
            display: flex;
            margin-bottom: 1rem;
        }

        .info-label {
            font-weight: 600;
            width: 120px;
        }

        .info-value {
            flex: 1;
        }

        .edit-profile {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            left: 15px;
        }

        .dropdown-btn {
            cursor: pointer;
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 5px;
            background: #374151;
            border-radius: 4px;
        }

        .dropdown-btn:hover {
            background: #1e293b;
        }

        .sidebar .dropdown-content {
            display: none;
            list-style-type: none;
            padding-left: 0;
            margin-left: 1rem;
        }

        .sidebar .dropdown-content a {
            padding: 0.5rem 1rem;
            text-decoration: none;
            display: block;
            background: #f9fafb;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }

        .sidebar .dropdown-content a:hover {
            background-color: #e5e7eb;
        }

        .sidebar .dropdown:hover .dropdown-content,
        .sidebar .dropdown.active .dropdown-content {
            display: block;
        }

        .sidebar .dropdown-submenu {
            position: relative;
            margin-left: 1rem;
        }

        .sidebar .dropdown-submenu .dropdown-content {
            margin-left: 1rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        .submit-btn {
            background-color: #3b82f6;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #2563eb;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .user-profile-content {
                flex-direction: column;
            }

            .user-profile-left {
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding-right: 0;
                padding-bottom: 2rem;
                margin-bottom: 2rem;
            }

            .user-profile-right {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
    <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
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
                <h1>Master Admin</h1>
                @if(Route::has('login'))
                @auth
                <x-app-layout></x-app-layout>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                @endauth
                @endif
            </header>


            <div class="user-profile">
                <div class="user-profile-content">
                    <div class="user-profile-right">
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
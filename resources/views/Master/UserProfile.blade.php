<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    @include('admin.Headlinks')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('Master.StyleForProfile')
</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
            <nav>
                <a href="{{ url('home') }}" >
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ url('admins') }}" >
                    <i class="fas fa-user-shield"></i> Admins
                </a>
                <a href="{{ url('users') }}" class="active">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="{{ url('master-messenger') }}">
                    <i class="fas fa-comments"></i> Messages
                </a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>User Profile</h1>
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
                    <div class="user-profile-left">
                    <img class="user-avatar" src="{{ Storage::url($user->profile_picture) }}" alt="Profile Picture">
                        <div class="user-info">
                            <h2>{{ $user->name }}</h2>
                            <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                            <p>
                                @if ($user->is_online)
                                Status: Online
                                <span class="online-status-dot"></span>
                                @else
                                Last Sign In: {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'N/A' }}
                                @endif
                            </p>
                        </div>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-user"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                    <div class="user-profile-right">
                        <div class="personal-info">
                            <h3>Personal Information</h3>
                            <div class="info-item">
                                <span class="info-label">Full Name:</span>
                                <span class="info-value">{{ $user->name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $user->email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Phone:</span>
                                <span class="info-value">{{ $phoneNumber }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address:</span>
                                <span class="info-value">{{ $address }}</span>
                            </div>
                        </div>

                        <h3 class="tt">Adoption Requests</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Animal</th>
                                    <th>Status</th>
                                    <th>Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAdoptions as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->animal->name }}</td>
                                    <td>{{ $request->status }}</td>
                                    <td>{{ $request->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="tt">Animal Abuse Reports</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Report</th>
                                    <th>Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAbuseReports as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ Str::limit($report->description, 30) }}</td>
                                    <td>{{ $report->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>

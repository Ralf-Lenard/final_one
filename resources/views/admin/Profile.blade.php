<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Noah's Ark</title>
    @include('admin.Headlinks')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('admin.StyleProfile')
    <style>
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .edit-profile-btn {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
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
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Profile</h1>
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
                        </div>
                    </div>
                    <div class="user-profile-right">
                        <div class="profile-header">
                            <h3>Personal Information</h3>
                            <!-- Edit Profile Button -->
                            <a href="{{ url('admin-profile/edit') }}" class="btn btn-warning btn-sm edit-profile-btn">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>
                        <div class="personal-info">
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
                                <span class="info-value">{{ $user->phone_number ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address:</span>
                                <span class="info-value">{{ $user->address ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <h3 class="tt">Adoption Requests</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Animal Name</th>
                                    <th>Status</th>
                                    <th>Date Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAdoptions as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->animal->name }}</td>
                                    <td>{{ $request->status }}</td>
                                    <td>{{ $request->updated_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="tt">Animal Abuse Reports</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAbuseReports as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ Str::limit($report->description, 30) }}</td>
                                    <td>{{ $report->status }}</td>
                                    <td>{{ $report->updated_at->format('d-m-Y H:i') }}</td>
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

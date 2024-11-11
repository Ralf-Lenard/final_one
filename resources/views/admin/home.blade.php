<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.Headlinks')
    @include('admin.StyleHome')
    @include('admin.ScriptHome')

</head>

<body>

    <div class="wrapper">
        <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
            <nav>
                <a href="{{ url('home') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
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
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header" style="background-color: #3b82f6;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <h3>{{ $totalAnimals }}</h3>
                        <p>Total Animals</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header" style="background-color: #10b981;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <h3>{{ $pendingAdoptions }}</h3>
                        <p>Pending Adoptions</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header" style="background-color: #f59e0b;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <h3>
                            <div class="unread_message">{{auth()->user()->getMessageCount()}}</div>
                        </h3>
                        <p>Unread Messages</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header" style="background-color: #ef4444;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <h3>{{ $pendingAbuses }}</h3>
                        <p>Abuse Reports</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header" style="background-color: #8b5cf6;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <h3>{{ $upcomingMeetings }}</h3>
                        <p>Upcoming Meetings Today</p>
                    </div>
                </div>
            </section>
            <section class="content-grid">
                <div class="card">
                    <h2>Recent Activity</h2>
                    <table>
                        <tbody>
                            @foreach($recentActivities as $activity)
                            <tr>
                                <td>
                                    {{ $activity['message'] }}
                                </td>
                                <td>
                                    <span>{{ $activity['date'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                <!-- add a notification on this area -->
                <section class="content-col">
                    <div class="card mb-3">
                        <h2>Notifications</h2>
                        <ul id="notification-list" class="list-unstyled">
                            @forelse(auth()->user()->notifications as $notification)
                            <li class="notification-item mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="notification-message">
                                        <!-- Check if it's an adoption request -->
                                        @if(isset($notification->data['animalName']))

                                        {{ $notification->data['message'] ?? 'No Message' }}

                                        <strong> {{ $notification->data['first_name'] ?? 'No First Name' }} {{ $notification->data['last_name'] ?? 'No Last Name' }}</strong>
                                        @else
                                        <!-- Handle other notifications, like animal abuse reports -->
                                        {{ $notification->data['message'] ?? 'No Message' }}
                                        <strong>{{ $notification->data['reporter_name'] ?? 'No Name' }}</strong>
                                        @endif
                                    </div>
                                    <div class="notification-time">
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="notification-item">No Notifications Found</li>
                            @endforelse
                        </ul>
                    </div>





                    <div class="card">
                        <h2>Quick Actions</h2>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-plus me-2"></i>Add Animal
                        </button>
                        <a href="{{route('admin.adoption.requests')}}"><button class="btn btn-block">View Pending Adoptions</button></a>
                        <a href="{{route('admin.abuses.requests')}}"><button class="btn btn-block">View Pending Reports</button></a>
                    </div>
                </section>


            </section>
            <section class="charts-grid">
                <div class="card">
                    <h2>Adoption Rate</h2>
                    <canvas id="adoptionRateChart"></canvas>
                </div>
               
            </section>
        </main>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Animal Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('animal-profiles/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="species" class="form-label">Species</label>
                            <input type="text" class="form-control" name="species" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="medical_records" class="form-label">Medical Records</label>
                            <textarea class="form-control" name="medical_records" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" name="profile_picture" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload Animal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</body>

</html>
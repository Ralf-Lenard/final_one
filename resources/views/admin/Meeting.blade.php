<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include('admin.Headlinks')
    @include('admin.StyleForAll')
    @include('admin.ScriptMeeting')
</head>

<body>
    <div id="wrapper">
        <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
            <nav>
                <a href="{{ url('home') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('animal-profiles') }}"><i class="fas fa-paw"></i> Animals</a>
                <a href="{{ url('animal-locations') }}" ><i class="fas fa-map-marker-alt"></i> Animals Location</a>
                <a href="{{ url('adoption-requests') }}"><i class="fas fa-heart"></i> Adoption Requests</a>
                <a href="{{ url('reports') }}"><i class="fas fa-file-alt"></i> Reports</a>
                <a href="{{ url('approved-requests') }}" class="active"><i class="fas fa-check"></i> Create Meeting</a>
                <a href="{{ url('appointments') }}"  ><i class="fas fa-calendar-check"></i> Meeting Scheduled</a>
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
                <h1>Set Meeting</h1>
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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h1>Adoption Requests</h1>
                                        <div class="input-group" style="max-width: 300px;">
                                            <input type="text" id="searchAdoptionInput" class="form-control" placeholder="Search...">
                                            <button class="btn btn-outline-secondary" type="button" id="searchAdoptionButton">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Adopter Name</th>
                                                    <th>Animal Name</th>
                                                    <th>Set Meeting</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="adoption-list">
                                                @forelse ($approvedRequests as $request)
                                                <tr>
                                                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $request->animalProfile->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.schedule.meeting') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="adoption_request_id" value="{{ $request->id }}">
                                                            <input type="hidden" name="user_id" value="{{ $request->user_id }}">
                                                            <input type="text" name="meeting_date" id="meeting_date_{{ $request->id }}" class="form-control datetimepicker" required placeholder="Select meeting date">
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success">Schedule Meeting</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No approved adoption requests found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <nav aria-label="Adoption pagination">
                                        <ul class="pagination justify-content-center" id="adoptionPagination">
                                            <!-- Pagination for Adoption Requests -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <main class="main-content">
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h1>Report Requests</h1>
                                        <div class="input-group" style="max-width: 300px;">
                                            <input type="text" id="searchReportInput" class="form-control" placeholder="Search...">
                                            <button class="btn btn-outline-secondary" type="button" id="searchReportButton">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Reporter Name</th>
                                                    <th>Set Meeting</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="report-list">
                                                @forelse ($approvedRequestss as $requests)
                                                    <tr>
                                                        <td>{{ $requests->user->name ?? 'N/A' }}</td>
                                                        <td>
                                                            <form action="{{ route('admin.scheduleAbuse.meeting') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="animal_abuse_report_id" value="{{ $requests->id }}">
                                                                <input type="hidden" name="user_id" value="{{ $requests->user_id }}">
                                                                <input type="text" name="meeting_date" id="meeting_date_{{ $requests->id }}" class="form-control datetimepicker" required>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success">Schedule Meeting</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">No approved report requests found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <nav aria-label="Report pagination">
                                        <ul class="pagination justify-content-center" id="reportPagination">
                                            <!-- Pagination for Reports -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </section>
        </main>
    </div>


</body>

</html>
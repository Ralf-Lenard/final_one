<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Noah's Ark</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    @include('admin.Headlinks') <!-- Include necessary styles and scripts -->
    @include('admin.StyleAppointmentList')
    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>



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
                <a href="{{ url('approved-requests') }}"><i class="fas fa-check"></i> Create Meeting</a>
                <a href="{{ url('appointments') }}"  class="active"><i class="fas fa-calendar-check"></i> Meeting Scheduled</a>
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
                <h1>Scheduled Meetings</h1>
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
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Scheduled Meetings</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <button id="show-all-appointments" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-calendar-week me-2"></i>Show All Meetings
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Calendar</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Meetings for <span id="selected-date">All Dates</span></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <h3>Adoption Appointments</h3>
                                            <table class="table table-hover" id="adoption-appointments-table">
                                                <thead>
                                                    <tr>
                                                        <th>Meeting Date</th>
                                                        <th>Adopter Name</th>
                                                        <th>Animal Name</th>
                                                        <th>Update Schedule</th>
                                                        <th>Video Call Meeting</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($adoptionAppointments as $appointment)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->meeting_date)->format('d-m-Y H:i') }}</td>
                                                        <td>{{ $appointment->adoptionRequest->user->name ?? 'N/A' }}</td>
                                                        <td>{{ $appointment->adoptionRequest->animalProfile->name ?? 'N/A' }}</td>
                                                        <td>
                                                            <button class="btn btn-warning update-schedule-btn" data-id="{{ $appointment->id }}" data-date="{{ $appointment->meeting_date }}">Update</button>
                                                        </td>
                                                        <td>
                                                            <button>
                                                                @include('admin.VideoCallAdoption')
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('admin.adoption.complete', ['id' => $appointment->adoption_request_id]) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">Complete Verification</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">No meetings found.</td>
                                                    </tr>

                                                    @endforelse
                                                </tbody>
                                            </table>

                                            <h3>Abuse Report Appointments</h3>
                                            <table id="abuse-appointments-table" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Meeting Date</th>
                                                        <th>User Name</th>
                                                        <th>Update Schedule</th>
                                                        <th>Video Call</th>
                                                        <th>Verification</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($abuseAppointments as $appointmentss)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($appointmentss->meeting_date)->format('d-m-Y H:i') }}</td>
                                                        <td>{{ $appointmentss->animalAbuseReport->user->name ?? 'N/A' }}</td>
                                                        <td>
                                                            <button class="btn btn-warning update-schedule-btn" data-id="{{ $appointmentss->id }}" data-date="{{ $appointmentss->meeting_date }}">Update</button>
                                                        </td>
                                                        <td>
                                                            <button>
                                                                @include('admin.VideoCallAbuse')
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('admin.abuses.complete', ['id' => $appointmentss->animal_abuse_report_id]) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">Complete Verification</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No meetings found.</td>
                                                    </tr>


                                                    @endforelse

                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </section>
            <!-- Update Schedule Modal -->
            <div id="updateScheduleModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Update Meeting Schedule</h2>
                    <form id="updateScheduleForm">
                        @csrf
                        <input type="hidden" name="meeting_id" id="meeting_id">
                        <!-- Ensure this is correctly named -->
                        <div class="form-group">
                            <label for="new_meeting_date">New Meeting Date and Time:</label>
                            <input type="datetime-local" name="meeting_date" id="new_meeting_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </form>
                </div>
            </div>

    </div>


    @include('admin.ScriptAppointmentList')

</body>

</html>
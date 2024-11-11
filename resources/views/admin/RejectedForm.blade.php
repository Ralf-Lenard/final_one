<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noah's Ark</title>
    @include('admin.Headlinks')
    @include('admin.StyleForAll')
    @include('admin.ScriptAdoptionRequested')

</head>

<body>
    <div class="wrapper">
    <aside class="sidebar">
            <h2>Noah's Ark Admin</h2>
            <nav>
                <a href="{{ url('home') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ url('animal-profiles') }}"><i class="fas fa-paw"></i> Animals</a>
                <a href="{{ url('animal-locations') }}" ><i class="fas fa-map-marker-alt"></i> Animals Location</a>
                <a href="{{ url('adoption-requests') }}"><i class="fas fa-heart"></i> Adoption Requests</a>
                <a href="{{ url('reports') }}"><i class="fas fa-file-alt"></i> Reports</a>
                <a href="{{ url('approved-requests') }}" ><i class="fas fa-check"></i> Create Meeting</a>
                <a href="{{ url('appointments') }}"  ><i class="fas fa-calendar-check"></i> Meeting Scheduled</a>
                <a href="{{ url('admin-messenger') }}"><i class="fas fa-comments"></i> Messages</a>

                <!-- Multi-Level Dropdown -->
                <div class="dropdown" class="active">
                    <button class="dropdown-btn"><i class="fas fa-folder-open"></i> Completed and Rejected</button>
                    <ul class="dropdown-content">
                        <li><a href="{{ url('completed-adoption') }}"><i class="fas fa-check-circle"></i> Completed Adoption Form</a></li>
                        <li><a href="{{ url('completed/Animal-Abuse-Report') }}"><i class="fas fa-exclamation-triangle"></i> Completed Report Form</a></li>

                        <ul class="dropdown-submenu">
                            <li><a href="{{ url('rejected-Form') }}" class="active"><i class="fas fa-times-circle"></i> Rejected Adoption Form</a></li>
                            <li><a href="{{ url('rejected') }}" ><i class="fas fa-ban"></i> Rejected Report Form</a></li>
                        </ul>

                    </ul>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <h1>Rejected Adoption Request</h1>
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
                                        <h1>Adoption Request</h1>
                                        <div class="input-group" style="max-width: 300px;">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Gender</th>
                                                    <th>Contact</th>
                                                    <th>Salary</th>
                                                    <th>Questions</th>
                                                    <th>ID</th>
                                                    <th>Reason</th>
                                                    <th>Admin</th>

                                                </tr>
                                            </thead>
                                            <tbody id="adoption-list">
                                                @foreach ($rejectedRequests as $reject)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            {{ $reject->first_name }} {{ $reject->last_name }}
                                                            <span class="d-block text-muted small">{{ $reject->address }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $reject->gender }}</td>
                                                    <td>{{ $reject->phone_number }}</td>
                                                    <td>₱{{ number_format($reject->salary, 2) }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#questionsModal">
                                                            <i class="fas fa-eye me-1"></i> View Answers
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <img src="{{ Storage::url($reject->valid_id) }}" alt="Valid ID" class="img-id" data-bs-toggle="modal" data-bs-target="#idModal" data-bs-img-src="/placeholder.svg?height=400&width=400" data-bs-img-title="Valid ID">
                                                            <img src="{{ Storage::url($reject->valid_id_with_owner) }}" alt="ID with Owner" class="img-id" data-bs-toggle="modal" data-bs-target="#idModal" data-bs-img-src="/placeholder.svg?height=400&width=400" data-bs-img-title="ID with Owner">
                                                        </div>
                                                    </td>
                                                    <td>{{ $reject->reason }}</td>
                                                    <td>@if($reject->admin)
                                                        {{ $reject->admin->name }}
                                                        @else
                                                        N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                                <!-- Questions Modal -->
                                                <div class="modal fade" id="questionsModal" tabindex="-1" aria-labelledby="questionsModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="questionsModalLabel">Adoption Questions</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Question 1:</strong> {{ $reject->question1 }}</p>
                                                                <p><strong>Question 2:</strong> {{ $reject->question2 }}</p>
                                                                <p><strong>Question 3:</strong> {{ $reject->question3 }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- ID Modal -->
                                                <div class="modal fade" id="idModal" tabindex="-1" aria-labelledby="idModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="idModalLabel">ID Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ Storage::url($reject->valid_id) }}" alt="ID" id="modalImage">
                                                                <img src="{{ Storage::url($reject->valid_id_with_owner) }}" alt="ID" id="modalImage">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="Adoption requests pagination" class="mt-4">
                                        <ul class="pagination justify-content-center" id="pagination">
                                            <!-- Pagination will be dynamically populated by JavaScript -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </section>
    </div>
</body>

</html>
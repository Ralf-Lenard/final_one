<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    @include('admin.Headlinks')
    @include('admin.StyleForAll')
    @include('admin.ScriptAnimalList')
</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
                <h2>Noah's Ark Admin</h2>
                <nav>
                    <a href="{{ url('home') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="{{ url('animal-profiles') }}" class="active"><i class="fas fa-paw"></i> Animals</a>
                    <a href="{{ url('animal-locations') }}" ><i class="fas fa-map-marker-alt"></i> Animals Location</a>
                    <a href="{{ url('adoption-requests') }}"><i class="fas fa-heart"></i> Adoption Requests</a>
                    <a href="{{ url('reports') }}" ><i class="fas fa-file-alt"></i> Reports</a>
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
                <h1>Animal List</h1>
                @if(Route::has('login'))
                @auth
                <x-app-layout></x-app-layout>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                @endauth
                @endif
            </header> <!-- Sidebar and header -->

            <section class="stats-grid">
                <div class="stat-card">
                    <main class="main-content">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="fas fa-plus me-2"></i>Add Animal
                                    </button>
                                    <div class="input-group" style="max-width: 300px;">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Search animals...">
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
                                                <th>Species</th>
                                                <th>Description</th>
                                                <th>Age</th>
                                                <th>Medical History</th>
                                                <th>Profile Picture</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="animal-list">
                                            @foreach ($animalProfiles as $animal)
                                            <tr id="animal-{{ $animal->id }}">
                                                <td>{{ $animal->name }}</td>
                                                <td>{{ $animal->species }}</td>
                                                <td>{{ $animal->description }}</td>
                                                <td>{{ $animal->age }}</td>
                                                <td>{{ $animal->medical_records }}</td>
                                                <td>
                                                    <img src="{{ Storage::url($animal->profile_picture) }}" class="img-thumbnail" alt="{{ $animal->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateModal{{ $animal->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $animal->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                    <!-- Update Modal -->
                                                    @include('admin.ModalUpdateAnimalProfile', ['animal' => $animal])

                                                    <!-- Delete Modal -->
                                                    @include('admin.ModalDeleteAnimalProfile', ['animal' => $animal])
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <nav aria-label="Animal profiles pagination">
                                    <ul class="pagination justify-content-center" id="pagination">
                                        <!-- Pagination will be dynamically populated by JavaScript -->
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Upload Modal -->
                        @include('admin.ModalUploadAnimalProfile')
                    </main>
                </div>
            </section>
    </div>
</body>

</html>
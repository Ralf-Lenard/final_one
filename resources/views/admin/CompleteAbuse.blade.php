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
                <a href="{{ url('approved-requests') }}"><i class="fas fa-check"></i> Create Meeting</a>
                <a href="{{ url('appointments') }}"  ><i class="fas fa-calendar-check"></i> Meeting Scheduled</a>
                <a href="{{ url('admin-messenger') }}"><i class="fas fa-comments"></i> Messages</a>

                <!-- Multi-Level Dropdown -->
                <div class="dropdown" class="active">
                    <button class="dropdown-btn"><i class="fas fa-folder-open"></i> Completed and Rejected</button>
                    <ul class="dropdown-content">
                        <li><a href="{{ url('completed-adoption') }}"><i class="fas fa-check-circle"></i> Completed Adoption Form</a></li>
                        <li><a href="{{ url('completed/Animal-Abuse-Report') }}" class="active"><i class="fas fa-exclamation-triangle"></i> Completed Report Form</a></li>

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
                <h1>Completed Animal Abuse Report</h1>
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
                                                    <th>Description</th>
                                                    <th>Photos</th>
                                                    <th>Videos</th>
                                                </tr>
                                            </thead>
                                            <tbody id="adoption-list">
                                                @foreach ($completeRequests as $abuse)
                                                <tr class="odd gradeX">
                                                    <td>{{ $abuse->description }}</td>
                                                    <td>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($abuse->{'photos' . $i})
                                                            <img width="40px" height="40px" src="{{ Storage::url($abuse->{'photos' . $i}) }}" class="card-img-top" alt="Photo {{ $i }}">
                                                            @else
                                                            <p>No image available.</p>
                                                            @break
                                                            @endif
                                                            @endfor
                                                    </td>
                                                    <td>
                                                        @for ($i = 1; $i <= 3; $i++)
                                                            @if ($abuse->{'videos' . $i})
                                                            <video width="100" height="80" controls>
                                                                <source src="{{ Storage::url($abuse->{'videos' . $i}) }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                            @else
                                                            <p>No video available.</p>
                                                            @break
                                                            @endif
                                                            @endfor
                                                    </td>
                                                    
                                                </tr>
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
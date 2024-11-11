<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.Headlinks')
    @include('admin.StyleForAll')
    @include('admin.ScriptAnimalAbuseRequested')
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
                <a href="{{ url('reports') }}" class="active"><i class="fas fa-file-alt"></i> Reports</a>
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
                <h1>Animal Abuse Report</h1>
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
                                        <h1>Animal Abuse Report</h1>
                                        <div class="input-group" style="max-width: 300px;">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                            <button id="searchButton" class="btn btn-outline-secondary">
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
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="abuse-list">
                                                @forelse ($abuses as $abuse)
                                                <tr>
                                                    <td>{{ $abuse->description }}</td>
                                                    <td>
                                                        <div class="d-flex flex-wrap">
                                                            @php $photosAvailable = false; @endphp
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($abuse->{'photos' . $i})
                                                                @php $photosAvailable = true; @endphp
                                                                <a href="#" data-toggle="modal" data-target="#imageModal" data-image="{{ Storage::url($abuse->{'photos' . $i}) }}">
                                                                    <img width="100" height="100" src="{{ Storage::url($abuse->{'photos' . $i}) }}" class="img-thumbnail m-1" alt="Photo {{ $i }}">
                                                                </a>
                                                                @endif
                                                                @endfor
                                                                @if (!$photosAvailable)
                                                                <p class="text-muted">No photos available.</p>
                                                                @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap">
                                                            @php $videosAvailable = false; @endphp
                                                            @for ($i = 1; $i <= 3; $i++)
                                                                @if ($abuse->{'videos' . $i})
                                                                @php $videosAvailable = true; @endphp
                                                                <a href="#" data-toggle="modal" data-target="#videoModal" data-video="{{ Storage::url($abuse->{'videos' . $i}) }}">
                                                                    <video width="160" height="140" controls class="m-1">
                                                                        <source src="{{ Storage::url($abuse->{'videos' . $i}) }}" type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </a>
                                                                @endif
                                                                @endfor
                                                                @if (!$videosAvailable)
                                                                <p class="text-muted">No videos available.</p>
                                                                @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($abuse->status == 'pending')
                                                        <form action="{{ route('admin.abuses.verify', $abuse->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning">Verify</button>
                                                        </form>
                                                        @endif
                                                        @if ($abuse->status == 'Verifying')
                                                        <form action="{{ route('admin.abuses.approve', $abuse->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Approve</button>
                                                        </form>
                                                        <button type="button" class="btn btn-danger" onclick="showRejectModal({{ $abuse->id }})">Reject</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No animal abuse report found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Image Zoom Modal -->
                                        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img id="modalImage" src="" class="img-fluid" alt="Zoomed Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Video Zoom Modal -->
                                        <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <video id="modalVideo" controls class="img-fluid">
                                                            <source src="" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pagination Controls -->
                                        <ul id="pagination" class="pagination justify-content-center">
                                            <!-- Pagination buttons will be dynamically generated here -->
                                        </ul>


                                        <!-- Include jQuery and Bootstrap JS for functionality -->
                                        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                                        <!-- Script to handle image zoom in modal -->
                                        <script>
                                            $('#imageModal').on('show.bs.modal', function(event) {
                                                var button = $(event.relatedTarget);
                                                var imageUrl = button.data('image');
                                                var modal = $(this);
                                                modal.find('#modalImage').attr('src', imageUrl);
                                            });
                                        </script>

                                        <!-- Script to handle video zoom in modal -->
                                        <script>
                                            $('#videoModal').on('show.bs.modal', function(event) {
                                                var button = $(event.relatedTarget);
                                                var videoUrl = button.data('video');
                                                var modal = $(this);
                                                modal.find('#modalVideo source').attr('src', videoUrl);
                                                modal.find('#modalVideo')[0].load(); // Reload the video source
                                            });
                                        </script>

                                    </div>


                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectAbusesModal" tabindex="-1" aria-labelledby="rejectAbusesModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form id="rejectForm" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectAbudsesModalLabel">Reject Report</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="reason">Reason for Rejection:</label>
                                                            <textarea class="form-control" id="reason" name="reason" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </section>
    </div>
</body>

</html>
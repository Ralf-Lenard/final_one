<!DOCTYPE html>
<html lang="en">

<head>

    @include('user.headlinks')
    @include('user.ScriptHome')
    @include('user.ScriptAnimalAbuseReport')

    <!-- Bootstrap CSS (in the <head> section) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (before </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



</head>

<body>
    @include('user.stylinghead')

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header style="position: fixed; top: 0; z-index: 1000;">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('home') }}">
                    <h2>Noah's <em>Ark</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('home') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('report/abuse') }}">Report Animal Abuse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user-messenger') }}">
                                <div class="nav-link-container">
                                    <i class="fas fa-comment-dots"></i> Message
                                    <span class="badge badge-danger message-count">{{ auth()->user()->getMessageCount() }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('User-Video-call') }}">Virtual Meeting</a>
                        </li>

                        <!-- Notification Dropdown -->
                        @include('user.Notification')

                        <!-- User Dropdown -->
                        @if(Route::has('login'))
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   Logout
                                </a>
                            </div>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                        </li>
                        @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <div class="full-height">
        <div class="form-container">
            <h2>Report Animal Abuse</h2>

            @if(session('error'))
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Script to trigger modal automatically on page load -->
@if(session('success'))
    <script>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    </script>
@endif

@if(session('error'))
    <script>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    </script>
@endif




            <form action="{{ route('report.abuses.submit') }}" method="POST" enctype="multipart/form-data" style="background-color: #faf3e0; padding: 20px; border-radius: 12px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <h2 class="text-center mb-4" style="color: #6a4a3c;">Animal Abuse Report</h2>

                <div class="form-group">
                    <label for="description" style="color: #4f3829; font-weight: bold;">Description of Abuse</label>
                    <textarea class="form-control" id="description" name="description" rows="3" style="border: 1px solid #d4a373; border-radius: 8px; color: #4f3829;" required>{{ old('description') }}</textarea>
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <h5 class="mt-4 mb-3" style="color: #6a4a3c; font-weight: bold;">Upload Photos (optional)</h5>
                <div id="photoInputs">
                    <div class="form-group">
                        <label for="photos1" style="color: #4f3829;">Upload Photo 1</label>
                        <input type="file" class="form-control" id="photos1" name="photos1" accept="image/*" style="border: 1px solid #d4a373; border-radius: 8px;">
                    </div>
                </div>

                <h5 class="mt-4 mb-3" style="color: #6a4a3c; font-weight: bold;">Upload Videos (optional)</h5>
                <div id="videoInputs">
                    <div class="form-group">
                        <label for="videos1" style="color: #4f3829;">Upload Video 1</label>
                        <input type="file" class="form-control" id="videos1" name="videos1" accept="video/*" style="border: 1px solid #d4a373; border-radius: 8px;">
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn" style="background-color: #8b5e34; color: #fff; border-radius: 8px; font-weight: bold;">Submit Report</button>
                </div>
            </form>


        </div>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="/user/vendor/jquery/jquery.min.js"></script>
    <script src="/user/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="/user/assets/js/custom.js"></script>
    <script src="/user/assets/js/owl.js"></script>
    <script src="/user/assets/js/slick.js"></script>
    <script src="/user/assets/js/isotope.js"></script>
    <script src="/user/assets/js/accordions.js"></script>

    <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t) { //declaring the array outside of the
            if (!cleared[t.id]) { //function to keep flag throughout 
                cleared[t.id] = 1; //entire page and to use it throughout
                t.value = '';
                t.style.color = '#000';
            }
        }
    </script>

    <script>
        // Enable Pusher logging (only for development)
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('c27cf1cca7e151dffc12', {
            cluster: 'ap1'
        });

        // Subscribe to your Pusher channel
        var channel = pusher.subscribe('my-channel');

        // Bind to the event you're listening for
        channel.bind('my-event', function(data) {
            // Update the message count using AJAX
            $.ajax({
                url: "{{ route('unreadcount') }}", // Ensure this route is correct
                method: "GET",
                success: function(response) {
                    // Update the message count displayed
                    $('.message-count').html(response.count);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    </script>

</body>

</html>
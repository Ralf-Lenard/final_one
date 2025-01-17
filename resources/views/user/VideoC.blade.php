<!DOCTYPE html>
<html lang="en">
<head>
    @include('user.headlinks')
    @include('user.ScriptHome')
</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Header -->
    <header style="position: relative; top: 0; z-index: 1000;">
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
                        <li class="nav-item">
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
                        <li class="nav-item active">
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

    <div class="latest-products" id="latest-products" style="margin-top: 40px;">
        <div class="container">
            <div class="row">
                <!-- Video Call Component -->
                @include('user.VideoCall')   
            </div>
        </div>
    </div>

    <!-- Additional Scripts -->
    <script src="/user/assets/js/custom.js"></script>
    <script src="/user/assets/js/owl.js"></script>
    <script src="/user/assets/js/slick.js"></script>
    <script src="/user/assets/js/isotope.js"></script>
    <script src="/user/assets/js/accordions.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const descriptions = document.querySelectorAll('.description');

            // Hide preloader after the content is loaded
            setTimeout(function() {
                document.getElementById('preloader').style.display = 'none';
            }, 100); // Adjust the timing as necessary
        });
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

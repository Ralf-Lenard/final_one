<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Noah's Ark</title>

    <!-- Include CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="/user/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/user/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/user/assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="/user/assets/css/owl.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="/css/app.css" rel="stylesheet"> <!-- Assuming you have an app.css for styles -->

    <!-- Include Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @livewireStyles
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
    <header  style="position: relative; top: 0;">
        <nav class="navbar navbar-expand-lg" >
            <div class="container">
                <a class="navbar-brand" href="{{ url('home') }}">
                    <h2>Noah's <em>Ark</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item "><a class="nav-link" href="{{ url('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/report/abuse') }}">Report Animal Abuse</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user-messenger') }}">
                                <div class="nav-link-container">
                                    <i class="fas fa-comment-dots"></i> Message
                                    <span class="badge badge-danger message-count">{{ auth()->user()->getMessageCount() }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('User-Video-call') }}">Virtual Meeting</a></li>

                        @include('user.Notification')

                        @if(Route::has('login'))
                        @auth
                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            </div>
                        </li>
                        @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a></li>
                        @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="container mt-5 profile-section" x-data="{ show: false }">
        <h2>User Profile</h2>

        <!-- Personal Information Card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Personal Information</h5>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone }}</p>
                <p><strong>Address:</strong> {{ $user->address }}</p>
            </div>
        </div>


    <script src="/user/assets/js/custom.js"></script>
    <script src="/user/assets/js/owl.js"></script>
    <script src="/user/assets/js/slick.js"></script>
    <script src="/user/assets/js/isotope.js"></script>
    <script src="/user/assets/js/accordions.js"></script>

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

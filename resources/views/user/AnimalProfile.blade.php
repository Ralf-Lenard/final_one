<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <title>Noah's Ark</title>

  @include('user.headlinks')

  @include('user.ScriptHome')

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
  <header class="" style="position: relative; top: 0;">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="{{url('home')}}">
          <h2>Noah's <em>Ark</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{url('home')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/abuse')}}">Report Animal Abuse</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('user-messenger') }}">
                <div class="nav-link-container">
                  <i class="fas fa-comment-dots"></i> Message
                  <span class="badge badge-danger message-count">{{ auth()->user()->getMessageCount() }}</span>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('User-Video-call') }}">Virtual Meeting</a>
            </li>
            <ul class="navbar-nav ml-auto">
              @include('user.Notification')
            </ul>

            @if(Route::has('login'))
            @auth
            <!-- Display user profile and logout links -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
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
  <!-- Banner Starts Here -->
  <!-- Banner Ends Here -->

  <div class="latest-products" style="margin-top: 15px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

        </div>

        <div class="container mt-5">
          <div class="card border-0 shadow" style="background-color: #f8f1e7; border-radius: 15px;">
            <div class="card-header text-white" style="background-color: #7b4a12; border-top-left-radius: 15px; border-top-right-radius: 15px;">
              <h2 class="text-center">{{ $animal->name }}'s Profile</h2>
            </div>
            <div class="card-body" style="background-color: #fdf7f2;">
              <div class="row">
                <div class="col-md-4 text-center">
                  <img src="{{ Storage::url($animal->profile_picture) }}" class="img-fluid rounded-circle" alt="{{ $animal->name }}" style="max-width: 200px; border: 5px solid #7b4a12;">
                </div>
                <div class="col-md-8">
                  <h4 class="text-muted">Description</h4>
                  <p>{{ $animal->description }}</p>
                  <hr style="border-top: 2px solid #7b4a12;">
                  <h4 class="text-muted">Details</h4>
                  <ul class="list-unstyled">
                    <li><strong>Name:</strong> {{ $animal->name }}</li>
                    <li><strong>Species:</strong> {{ $animal->species }}</li>
                    <li><strong>Age:</strong> {{ $animal->age }}</li>
                    <li><strong>Medical Records:</strong> {{ $animal->medical_records ?? 'No records available' }}</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-footer text-center" style="background-color: #7b4a12; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
              <a href="{{ route('adopt.show', $animal->id) }}" class="btn btn-success btn-lg" style="background-color: #4f9a56; border-color: #4f9a56;">Adopt {{ $animal->name }}</a>
            </div>
          </div>
        </div>

      </div>
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
      if (!cleared[t.id]) { // function makes it static and global
        cleared[t.id] = 1; // you could use true and false, but that's more typing
        t.value = ''; // with more chance of typos
        t.style.color = '#fff';
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
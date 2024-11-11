<!DOCTYPE html>
<html lang="en">

<head>

    @include('user.headlinks')
    @include('user.ScriptHome')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (before </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
      
        /* Badge for Message Count */
        .message-count {
            font-size: 12px;
            padding: 4px 5px;
            border-radius: 5px;
            background-color: #a85b45; /* Accent brown for the badge */
            color: white;
        }

        /* Header & Title Section */
        .section-heading h2 {
            color: #7b4f3d;
            font-family: 'Georgia', serif;
            border-bottom: 2px solid #d9a679; /* Accent underline */
     
        }

        /* Search Bar Styling */
        .form-inline .form-control {
            border: 1px solid #7b4f3d;
            border-radius: 5px;
            padding: 8px;
        }
        .form-inline .btn-outline-success {
            color: #7b4f3d;
            border-color: #7b4f3d;
        }
        .form-inline .btn-outline-success:hover {
            background-color: #7b4f3d;
            color: white;
        }

        /* Animal Cards */
        .product-item {
            border: 1px solid #d3b8a1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .product-item img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #d3b8a1;
        }
        .product-item .down-content {
            background-color: #f7f3e9;
            padding: 15px;
            
        }
        .product-item h4 {
            color: #7b4f3d;
            font-size: 18px;
            margin-top: 10px;
        }
        .product-item h6 {
            color: #a85b45;
            font-size: 14px;
        }
        .product-item p.description {
            color: #4d3d33;
            font-size: 14px;
            
        }
        .product-item a {
            text-decoration: none;
            color: #7b4f3d;
        }

        /* Footer */
        footer {
            background-color: #7b4f3d;
            color: white;
            padding: 20px 0;
        }
        footer a {
            color: #d9a679;
        }

    </style>

</head>

<body>
        @include('user.stylinghead')
    <!-- Preloader -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

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
                        <li class="nav-item active">
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
    <!-- Main Content -->
    <div class="latest-products" id="latest-products" style="margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading" style="margin-top:15px; margin-bottom: 15px;">
                        <h2 class="d-inline">OUR PETS</h2>

                        <!-- Search Form -->
                        <form action="{{ route('animals.search') }}" method="GET" class="form-inline float-right" style="margin-top: -7px;">
                            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search for pets..." aria-label="Search" value="{{ request()->input('query') }}">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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

<!-- Error Modal -->
@if(session('error'))
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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

<!-- JavaScript to trigger the modals automatically on page load -->
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

                @if($animalProfiles->count())
                @foreach($animalProfiles as $animal)
                <div class="col-md-4" id="animal-{{ $animal->id }}">
                    <div class="product-item">
                        <a href="{{ route('animals.show', $animal->id) }}">
                            <img src="{{ Storage::url($animal->profile_picture) }}" class="card-img-top" alt="{{ $animal->name }}">
                        </a>
                        <div class="down-content">
                            <a href="#">
                                <h4>{{ $animal->name }}</h4>
                            </a>
                            <h6>{{ $animal->age }}</h6>
                            <p class="description" data-description="{{ $animal->description }}"></p>
                            <span><a href="{{ route('animals.show', $animal->id) }}">View Profile</a></span>
                        </div>
                    </div>
                </div>
                @endforeach



                @else
                <div class="col-md-12">
                    <p>No pets found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="/user/assets/js/custom.js"></script>
    <script src="/user/assets/js/owl.js"></script>
    <script src="/user/assets/js/slick.js"></script>
    <script src="/user/assets/js/isotope.js"></script>
    <script src="/user/assets/js/accordions.js"></script>
</body>
</html>

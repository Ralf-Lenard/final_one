<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>

    <!-- Add Font Awesome CDN (if not added yet) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
      /* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    color: #2e1a0f;
    background-color: #f8f3ed;
}

/* Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #8b5e34;
    color: #ffffff;
    position: relative;
}

.navbar h1 {
    font-size: 1.5rem;
}

/* Menu icon for mobile */
.menu-icon {
    display: none;
    font-size: 1.5rem;
    cursor: pointer;
}

.navbar ul {
    list-style-type: none;
    display: flex;
    gap: 1.5rem;
}

.navbar a {
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
}

/* Remove link styling */
.nav-link {
    color: inherit;
    text-decoration: none;
}

.nav-link:hover,
.nav-link:focus {
    color: inherit;
    text-decoration: none;
}

/* Right Side Menu for Mobile */
.side-menu {
    position: fixed;
    top: 0;
    right: -250px; /* Hidden by default */
    height: 100%;
    width: 250px;
    background-color: #8b5e34;
    box-shadow: -2px 0px 5px rgba(0, 0, 0, 0.5);
    transition: right 0.3s ease;
    padding-top: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    padding-left: 1rem;
    color: #fff;
}

.side-menu.active {
    right: 0; /* Show the menu */
}

.side-menu a {
    color: #ffffff;
    text-decoration: none;
    font-size: 1.2rem;
}

/* Hero Section */
.hero {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 4rem 1rem;
    background-color: #c4a484;
    color: #fff;
}

.hero h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    max-width: 600px;
}

.hero button {
    padding: 0.75rem 2rem;
    font-size: 1rem;
    color: #8b5e34;
    background-color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease;
}

.hero button:hover {
    background-color: #f1d8b3;
}

.back-arrow {
    display: none; /* Hide by default */
    color: #ffffff;
    font-size: 30px;
    margin-left: 10px;
    cursor: pointer; /* Make it clickable */
}

/* Responsive */
/* For mobile view (below 768px) */
/* For mobile view (below 768px) */
@media (max-width: 768px) {
    .navbar ul {
        display: none;  /* Hide navbar links */
    }

    /* Hamburger menu (only shows on mobile) */
    .menu-icon {
        display: block;
        color: #ffffff;
        font-size: 30px;  /* Adjust the size as needed */
        cursor: pointer;
      
    }

    /* Side menu */
    .side-menu {
        position: fixed;
        top: 0;
        right: -250px;  /* Hidden by default */
        height: 100%;
        width: 250px;
        background-color: #8b5e34;
        box-shadow: -2px 0px 5px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease;
        padding-top: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        padding-left: 1rem;
        color: #fff;
    }

    .side-menu.active {
        right: 0;  /* Show the menu */
    }

    .side-menu a {
        color: #ffffff;
        text-decoration: none;
        font-size: 1.2rem;
    }

    /* Back arrow (hidden by default) */
    .back-arrow {
        display: none;  /* Initially hide the back arrow */
        color: #ffffff;
        font-size: 30px;  /* Adjust the size as needed */
       

        cursor: pointer;  /* Make it clickable */
        z-index: 1001;  /* Make sure it's above the menu */
    }

    /* Show the back arrow when the side menu is active */
    .side-menu.active .back-arrow {
        display: block;
    }
}



        /* Animals Section */
        .animals {
            padding: 3rem 1rem;
            text-align: center;
            background-color: #e5dcc5;
        }

        .animals h3 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #8b5e34;
        }

        .animal-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .animal-card {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            width: 200px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .animal-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .animal-card h4 {
            padding: 0.5rem;
            font-size: 1.2rem;
            color: #4f3b2a;
            text-decoration: none;
            /* Remove underline from the title */
        }

        .animal-card p {
            padding: 0 0.5rem 0.5rem;
            font-size: 1rem;
            color: #4f3b2a;
            text-decoration: none;
            /* Remove underline from the description */
        }

        /* Contact Section */
        .contact {
            padding: 3rem 1rem;
            text-align: center;
            background-color: #f8f3ed;
        }

        .contact h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #8b5e34;
        }

        .contact button {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            color: #ffffff;
            background-color: #8b5e34;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .contact button:hover {
            background-color: #704a2b;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1rem;
            background-color: #8b5e34;
            color: #ffffff;
            font-size: 0.9rem;
        }

        .ani {
            text-decoration: none;
        }
    </style>
</head>

<body>
<div class="navbar">
    <h1>Noah's Ark</h1>
    
    <!-- Hamburger icon for mobile -->
    <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
    <ul>
        <li><a href="#about">About</a></li>
        <li><a href="#animals">Animals</a></li>
        <li><a href="#contact">Contact</a></li>
        <!-- Authentication Links -->
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

<!-- Side Menu -->
<div class="side-menu" id="sideMenu">
<div class="back-arrow" onclick="closeMenu()">
    <i class="fas fa-arrow-left"></i> <!-- Back arrow icon -->
</div>
    <a href="#about">About</a>
    <a href="#animals">Animals</a>
    <a href="#contact">Contact</a>
    @if(Route::has('login'))
    @auth
    <a href="{{ route('profile.show') }}">Profile</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    @else
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
    @endauth
    @endif
</div>





    <!-- Hero Section -->
    <section class="hero">
        <h2>Welcome to Noah's Ark Shelter</h2>
        <p>Rescue. Love. Rehome. Join us in our mission to provide safe havens for abused and abandoned animals. Adopt, volunteer, or support today!</p>
        <a class="ani" href="{{ auth()->check() ? route('animals.show', $animal->id) : route('login') }}" class="text-decoration-none">
            <button onclick="location.href='#animals'">Meet Our Animals</button>
        </a>
    </section>
    <!-- Animals Section -->
    <section id="animals" class="animals">
        <h3>Adoptable Animals</h3>
        <div class="animal-gallery row">
            @foreach ($animals as $animal)
            <div class="col-md-4 mb-4"> <!-- Use Bootstrap grid for responsive design -->
                <div class="animal-card card">
                    <a class="ani" href="{{ auth()->check() ? route('animals.show', $animal->id) : route('login') }}" class="text-decoration-none">
                        <img src="{{ Storage::url($animal->profile_picture) }}" class="card-img-top" alt="{{ $animal->name }}">
                        <div class="card-body">
                            <h4 class="card-title">{{ $animal->name }}</h4>
                            <p class="card-text">{{ $animal->description }}</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="contact">
        <h3>Contact Us</h3>
        <button onclick="location.href='mailto:info@noahsarkshelter.com'">Email Us</button>
    </section>

    <!-- Footer -->
    <footer class="footer">
        &copy; 2024 Noah's Ark Shelter. All rights reserved.
    </footer>

    <script>
// Toggle the side menu and show/hide the back arrow
function toggleMenu() {
    const sideMenu = document.getElementById('sideMenu');
    const backArrow = document.querySelector('.back-arrow');
    
    sideMenu.classList.toggle('active');
    backArrow.classList.toggle('active');
}

// Go back when back arrow is clicked
function closeMenu() {
    const sideMenu = document.getElementById('sideMenu');
    const backArrow = document.querySelector('.back-arrow');
    
    sideMenu.classList.remove('active');
    backArrow.classList.remove('active');
}


    </script>
</body>

</html>
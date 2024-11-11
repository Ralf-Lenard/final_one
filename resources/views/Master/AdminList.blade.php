<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    @include('admin.Headlinks')
    @include('admin.StyleForAll')

</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
        <h2>Noah's Ark Chief Admin</h2>
            <nav>
                <a href="{{ url('home') }}" >
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ url('admins') }}" class="active">
                    <i class="fas fa-user-shield" ></i> Admins
                </a>
                <a href="{{ url('users') }}">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="{{ url('master-messenger') }}">
                    <i class="fas fa-comments"></i> Messages
                </a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>Admins List</h1>
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
                                        <h1>Admins</h1>
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
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            @foreach($admins as $admin)
                                            <tr>
                                                <td><img width="50px" height="50px" style="border-radius: 50%;" class="user-avatar" src="{{ Storage::url($admin->profile_picture) }}" alt="Profile Picture"><span>{{ $admin->name }}</span></td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->usertype }}</td>
                                                <td>
                                                    @if($admin->usertype !== 'user')
                                                    <form action="{{ route('users.makeUser', $admin->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Make User</button>
                                                    </form>
                                                    @endif
                                                    
                                                    <a href="{{route('admin.profile.view', $admin->id)}}"><button type="submit" class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye me-1"></i> View Profile</button></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
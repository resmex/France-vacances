<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard | France Vacances</title>

    <!-- Fonts & Icons -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3 + Admin Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    @yield('css')
</head>

<body class="admin-body">
    <!-- Topbar -->
    <nav class="admin-topbar navbar navbar-expand-md">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <span class="brand-dot"><i class="fas fa-house"></i></span>
                <span>France<span class="brand-accent">Vacances</span> Admin</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ url('/') }}" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> View Site
                        </a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="admin-user-avatar">
                                    @if(Auth::user()->profile_photo)
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                    @else
                                    <i class="fas fa-user"></i>
                                    @endif
                                </span>
                                <span class="admin-user-name-gold">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('users.edit-profile') }}">
                                    <i class="fas fa-user-edit me-2"></i>{{ __('My Profile') }}
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    @auth
    <div class="container-fluid px-4">
        <!-- Flash Alerts -->
        @if (session()->has('success'))
            <div class="admin-alert admin-alert-success alert alert-dismissible fade show mt-3">
                <i class="fas fa-check-circle"></i>
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="admin-alert admin-alert-danger alert alert-dismissible fade show mt-3">
                <i class="fas fa-exclamation-circle"></i>
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <button class="admin-sidebar-toggle d-md-none" type="button" id="sidebarToggle">
            <i class="fas fa-bars"></i> Menu
        </button>

        <div class="row g-4 mt-0">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3">
                <div class="admin-sidebar" id="adminSidebar">
                    @php $authUser = auth()->user(); @endphp

                    <div class="admin-nav-group">Main</div>
                    <a href="{{ route('home') }}" class="admin-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-gauge-high"></i> Dashboard
                    </a>

                    @if ($authUser->isAdmin())
                    <div class="admin-nav-group">Sales &amp; Operations</div>
                    <a href="{{ route('bookings.index') }}" class="admin-nav-item {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> Bookings
                    </a>
                    <a href="{{ route('destinations.index') }}" class="admin-nav-item {{ request()->routeIs('destinations.*') ? 'active' : '' }}">
                        <i class="fas fa-house"></i> Properties
                    </a>
                    <a href="{{ route('users.index') }}" class="admin-nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Customers
                    </a>

                    <div class="admin-nav-group">Content</div>
                    <a href="{{ route('blog.index') }}" class="admin-nav-item {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> Blog Posts
                    </a>
                    <a href="{{ route('categories.index') }}" class="admin-nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="fas fa-map"></i> Categories (Regions)
                    </a>
                    <a href="{{ route('tags.index') }}" class="admin-nav-item {{ request()->routeIs('tags.*') ? 'active' : '' }}">
                        <i class="fas fa-tag"></i> Tags
                    </a>

                    <div class="admin-nav-group">Administration</div>
                    <a href="{{ route('users.index') }}" class="admin-nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-user-gear"></i> Users
                    </a>
                    <a href="{{ route('payments.index') }}" class="admin-nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i> Payments
                    </a>
                    <a href="{{ route('reports.index') }}" class="admin-nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                    @endif

                    <div class="admin-nav-divider"></div>
                    <a href="{{ url('/') }}" class="admin-nav-item">
                        <i class="fas fa-arrow-left"></i> Back to Website
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-10 col-md-9">
                <div class="admin-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    @if (session('status'))
    <div class="container-fluid px-4">
        <div class="admin-alert admin-alert-success alert alert-dismissible fade show mt-3">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var sidebarToggle = document.getElementById('sidebarToggle');
        var adminSidebar  = document.getElementById('adminSidebar');
        if (sidebarToggle && adminSidebar) {
            sidebarToggle.addEventListener('click', function () {
                adminSidebar.classList.toggle('admin-sidebar-open');
            });
        }
    </script>
    @yield('scripts')
</body>

</html>
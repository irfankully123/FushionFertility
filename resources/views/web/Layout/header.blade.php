<!-- Header -->
<div class="alert alert-info m-0 py-1 p-0">
    <p class="m-0 text-center px-2">
      Make Sure To Download 
        <a href="https://zoom.us/download?os=win" class="text-info" target="_blank"><i class="fa fa-download"></i> Zoom Windows</a>
        or <a href="https://play.google.com/store/apps/details?id=us.zoom.videomeetings" class="text-info" target="_blank"><i class="fa fa-play" aria-hidden="true"></i> Zoom App</a> 
          before an Appointment Video Consultation
    </p>
</div>


<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="/" class="navbar-brand logo">
                <img src="{{ asset('web/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="/" class="menu-logo">
                    <img src="{{ asset('web/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="main-nav">
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home')  }}">Home</a>
                </li>
                <li class="{{ request()->routeIs('doctors.listing') ? 'active' : '' }}">
                    <a href="{{ route('doctors.listing') }}">Doctors</a>
                </li>
                <li class="{{ request()->routeIs('blogs') ? 'active' : '' }}">
                    <a href="{{ route('blogs') }}">Blogs</a>
                </li>

                @auth()
                    @if(Auth::user()->patient() != null && Auth::user()->user_type == 'patient')
                        <li class="{{ request()->routeIs('patient.dashboard', 'patient.dashboard.profile', 'patient.dashboard.appointmentHistory', 'patient.dashboard.schedule.appointments') ? 'active' : '' }}">
                            <a href="{{ route('patient.dashboard', Auth::user()->id) }}">Patient Dashboard</a>
                        </li>
                    @endauth
                @endauth

                @auth()
                    @if (Auth::user()->hasRole(['admin','super']))
                        <li>
                            <a href="{{ route('dashboard.home') }}">Dashboard</a>
                        </li>
                    @endif
                    @if(Auth::user()->hasRole('doctor'))
                        <li>
                            <a href="{{ route('dashboard.doctor.home') }}">Dashboard</a>
                        </li>
                    @endif
                @endauth
                @auth
                    @if(auth()->user()->hasVerifiedEmail())
                        <li class="nav-item px-2 mobile-menu mobile-logout">
                            <form method="post" class="w-100" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link w-100 btn btn-primary">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item mobile-menu">
                            <a class="nav-link header-login" href="{{ route('login') }}">Login & Sign Up</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item mobile-menu mobile-logout px-2">
                        <a class="nav-link w-100 btn btn-primary" href="{{ route('login') }}">Login & Sign Up</a>
                    </li>
                @endauth
            </ul>
        </div>

        <ul class="nav header-navbar-rht">
            @auth
                <li class="nav-item">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-primary">Logout</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('login') }}">login / Signup </a>
                </li>
            @endauth

        </ul>
    </nav>
</header>
<!-- /Header -->

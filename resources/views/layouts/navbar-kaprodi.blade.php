<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5"><img src="{{ asset('images/logo.svg') }}" class="mr-2"
                alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini"><img src="{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
                     
            
            <!-- Profile Dropdown -->
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown"
                    id="profileDropdown">
                    <span class="mr-3 text-black d-none d-md-inline">{{ Auth::user()->nama }}</span>
                    <img src="{{ asset('images/faces/face28.jpg') }}" alt="profile"
                        style="width: 32px; height: 32px; border-radius: 50%;">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="">
                        <i class="ti-settings text-primary"></i>
                        Settings
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>

            

            <!-- Notifikasi Lonceng -->
            <li class="nav-item nav-settings">
                <a class="nav-link" href="#">
                    <i class="icon-bell mx-0"></i> 
                    @if ($unreadNotifications > 0)
                        <span class="badge badge-danger">{{ $unreadNotifications }}</span>
                    @endif
                </a>
            </li>   
        </ul>
    </div>
</nav>

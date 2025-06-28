<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('home') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assets/adminLTE/AdminLTE-4.0.0-beta3/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">SERBU TUTOR</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Manajemen User
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daftar User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Tambah User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(in_array(auth()->user()->role, ['admin', 'mentor']))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-book-fill"></i>
                        <p>
                            Manajemen Kursus
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daftar Kursus</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('courses.create') }}" class="nav-link {{ request()->routeIs('courses.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Tambah Kursus</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>
                            Pemesanan Kursus
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('course-bookings.index') }}" class="nav-link {{ request()->routeIs('course-bookings.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daftar Pemesanan</p>
                            </a>
                        </li>
                        @if(auth()->user()->role === 'student')
                        <li class="nav-item">
                            <a href="{{ route('course-bookings.create') }}" class="nav-link {{ request()->routeIs('course-bookings.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Pesan Kursus</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>
                            Profil
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Edit Profil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#" class="nav-link" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="nav-icon bi bi-box-arrow-right"></i>
                                    <p>Keluar</p>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>

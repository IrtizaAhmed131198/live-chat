<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <!--  Brand demo (display only for navbar-full and hide on below xl) -->

    <!-- ! Not required for layout-without-menu -->
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0  d-xl-none ">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base bx bx-menu icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                    <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                </a>
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">

            <!-- Style Switcher -->
            <li class="nav-item dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="icon-base bx bx-sun icon-md theme-icon-active"></i>
                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li>
                        <button type="button" class="dropdown-item align-items-center active"
                            data-bs-theme-value="light" aria-pressed="false">
                            <span><i class="icon-base bx bx-sun icon-md me-3" data-icon="sun"></i>Light</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
                            aria-pressed="true">
                            <span><i class="icon-base bx bx-moon icon-md me-3" data-icon="moon"></i>Dark</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
                            aria-pressed="false">
                            <span><i class="icon-base bx bx-desktop icon-md me-3" data-icon="desktop"></i>System</span>
                        </button>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            @php
                $user = DB::table('users')
                    ->where('id', auth()->user()->id)
                    ->first();
            @endphp
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset($user->image ?? 'assets/images/avatars/profile.jfif') }}" alt
                            class="rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset($user->image ?? 'assets/images/avatars/profile.jfif') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">
                                        John Doe
                                    </h6>
                                    <small class="text-body-secondary">Admin</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                            <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    @if (!Auth::check())
                        <li>
                            <a class="dropdown-item"
                                href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo-1/auth/login-basic">
                                <i class="icon-base bx bx-log-in icon-md me-3"></i><span>Login</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a style="display: flex" class="dropdown-item" href="">
                                <i class="icon-base bx bx-log-in icon-md me-3"></i>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

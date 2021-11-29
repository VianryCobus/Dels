<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion {{ (request()->is('dashtraining') || request()->is('dashelibraries/dashboard')) ? 'toggled' : '' }}" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DelS <sup>v.1.0</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Dashboard Training -->
    <li class="nav-item {{ request()->is('dashtraining') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashtrainings.index') }}">
            <i class="fas fa-fw fa-columns"></i>
            <span>Dashboard Training</span></a>
    </li>

    <!-- Nav Item - Dash Elibrary -->
    <li class="nav-item {{ request()->is('dashelibraries/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashelibraries.index') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>E-Library</span></a>
    </li>

    <!-- Nav Item - Report -->
    <li class="nav-item {{ request()->is('reports') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reports.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Report</span></a>
    </li>

    @if (session('isadmin'))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Master Data
        </div>

        <!-- Nav Item - Training Category -->
        <li class="nav-item {{ request()->is('categories') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="fas fa-fw fa-grip-horizontal"></i>
                <span>Training Category</span></a>
        </li>

        <!-- Nav Item - Training -->
        <li class="nav-item {{ request()->is('trainings') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('trainings.index') }}">
                <i class="fas fa-fw fa-random"></i>
                <span>Training</span></a>
        </li>

        <!-- Nav Item - User -->
        <li class="nav-item {{ request()->is('users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>User</span></a>
        </li>

        <!-- Nav Item - Elibrary -->
        <li class="nav-item {{ request()->is('elibraries') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('elibraries.index') }}">
                <i class="fas fa-fw fa-book-open"></i>
                <span>E-Library Admin</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
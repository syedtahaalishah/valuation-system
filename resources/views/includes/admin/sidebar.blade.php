<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard.index') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-house-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Valuation <sup>Portal</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Valuers
    </div>

    <!-- Nav Item - Report -->
    <li class="nav-item {{ request()->is('admin/valuers') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.valuers.index') }}">
            <i class="fas fa-user"></i>
            <span>Valuers</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Reports
    </div>

    <!-- Nav Item - Report -->
    <li class="nav-item {{ request()->is('admin/reports') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reports.index') }}">
            <i class="fas fa-file-contract"></i>
            <span>Reports</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Activities
    </div>

    <!-- Nav Item - Report -->
    <li class="nav-item {{ request()->is('admin/activities') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.activities.index') }}">
            <i class="far fa-eye"></i>
            <span>Activities</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Profile
    </div>

    <!-- Nav Item - Profile -->
    <li class="nav-item {{ request()->is('admin/profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.profile.index') }}">
            <i class="far fa-user"></i>
            <span>Profile</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="d-none d-md-inline text-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

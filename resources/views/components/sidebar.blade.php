<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-piggy-bank"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Banking Manager</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <x-sidebar.nav-item name="Dashboard" :href="route('dashboard')" :isActive="request()->routeIs('dashboard')"/>
    <x-sidebar.nav-item name="Bankkonten" :href="route('bankAccounts')" :isActive="request()->routeIs('bankAccounts')"/>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

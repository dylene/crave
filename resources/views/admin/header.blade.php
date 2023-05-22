<!-- Navbar -->

<nav
class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
id="layout-navbar"
>
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
<i class="bx bx-menu bx-sm text-danger"></i>
</a>
</div>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
<!-- Search -->
<div class="navbar-nav align-items-center">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bolder ms-2 text-capitalize">{{ config('app.name') }}</span>
    </a>
</div>
<!-- /Search -->

</div>
</nav>

<!-- / Navbar -->
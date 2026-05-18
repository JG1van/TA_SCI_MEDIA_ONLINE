<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo position-relative">

        <!-- Logo + Admin (diposisikan absolute di tengah) -->
        <a href="{{ route('admin.dashboard') }}"
            class="app-brand-center d-flex flex-column align-items-center text-center">
            <span class="app-brand-logo demo mb-1 mx-5">
                <img src="{{ asset('images/logo1.webp') }}" alt="Logo" width="40">
            </span>
            <span class="app-brand-text fw-bold">Admin</span>
        </a>

        <!-- Toggle Mobile tetap di kanan -->
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>

    </div>


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @include('admin.layouts.partials.sidebar-menu')
    </ul>
</aside>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" style="padding-left: 1rem;">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('logo.png') }}" width="180px" alt="">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item ">
            <a href="{{ url('/') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manajemen Kost</span>
        </li>
        <!-- Lokasi -->
        <li class="menu-item {{ Request::is('locations') || Request::is('locations/*') ? 'active' : '' }}">
            <a href="{{ url('locations') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-location-plus"></i>
                <div data-i18n="Lokasi">Lokasi</div>
            </a>
        </li>

        <!-- Kamar -->
        <li
            class="menu-item {{ Request::is('rooms') || Request::is('rooms/*') || Request::is('room/media') || Request::is('room/media/*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bed"></i>
                <div data-i18n="Kamar">Kamar</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('rooms') || Request::is('rooms/*') ? 'active' : '' }}">
                    <a href="{{ url('rooms') }}" class="menu-link">
                        <div data-i18n="Entri Data Kamar">Entri Data Kamar</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('room/media') || Request::is('room/media/*') ? 'active' : '' }}">
                    <a href="{{ url('room/media') }}" class="menu-link">
                        <div data-i18n="Entri Data Media Kamar">Entri Data Media Kamar</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Fasilitas -->
        <li class="menu-item {{ Request::is('facilities') || Request::is('facilities/*') ? 'active' : '' }}">
            <a href="{{ url('facilities') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bath"></i>
                <div data-i18n="Fasilitas">Fasilitas</div>
            </a>
        </li>
        <!-- Penghuni -->
        <li class="menu-item {{ Request::is('residents') || Request::is('residents/*') ? 'active' : '' }}">
            <a href="{{ url('residents') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="Penghuni">Penghuni</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manajemen Pembayaran</span>
        </li>
        <!-- Manajemen Pembayaran -->
        <li class="menu-item {{ Request::is('payments') || Request::is('payments/*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dollar"></i>
                <div data-i18n="Manajemen Pembayaran">Pembayaran</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('payments') || Request::is('payments/*') ? 'active' : '' }}">
                    <a href="{{ url('payments') }}" class="menu-link">
                        <div data-i18n="Report Pembayaran">Pembayaran</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div data-i18n="Telat Pembayaran">Telat Pembayaran</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Guest</span>
        </li>
        <!-- List Tunggu Guest -->
        <li class="menu-item {{ Request::is('guests') || Request::is('guests/*') ? 'active' : '' }}">
            <a href="{{ url('guests') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="List Tunggu Guest">List Tunggu Guest</div>
            </a>
        </li>
    </ul>
</aside>

<aside class="col-md-3 col-lg-2 sidebar">

    <div class="menu-title">MENU UTAMA</div>

    <nav class="nav flex-column">

        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           href="{{ route('dashboard') }}">

            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard

        </a>

        <div class="menu-title">MASTER DATA</div>

        <a class="nav-link {{ request()->routeIs('opds.*') ? 'active' : '' }}"
           href="{{ route('opds.index') }}">

            <i class="bi bi-building me-2"></i>
            Master OPD

        </a>

        <span class="nav-link disabled">
            <i class="bi bi-people me-2"></i>
            Master PNS
        </span>

        <span class="nav-link disabled">
            <i class="bi bi-briefcase me-2"></i>
            Master Jabatan
        </span>

        <span class="nav-link disabled">
            <i class="bi bi-book me-2"></i>
            Master SKJ
        </span>

        <div class="menu-title">PENGEMBANGAN ASN</div>

        <span class="nav-link disabled">
            <i class="bi bi-clipboard-data me-2"></i>
            Profiling ASN
        </span>

        <span class="nav-link disabled">
            <i class="bi bi-bar-chart me-2"></i>
            Analisis Gap
        </span>

        <span class="nav-link disabled">
            <i class="bi bi-mortarboard me-2"></i>
            Pengembangan
        </span>

        <span class="nav-link disabled">
            <i class="bi bi-file-earmark-text me-2"></i>
            Dokumen IDP
        </span>

        <div class="menu-title">ADMINISTRASI</div>

        <span class="nav-link disabled">
            <i class="bi bi-gear me-2"></i>
            Pengaturan
        </span>

    </nav>

</aside>

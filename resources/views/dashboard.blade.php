
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard - SI-IDP Indramayu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: Arial, sans-serif;
        }

        .navbar-custom {
            background-color: #123b60;
        }

        .sidebar {
            min-height: calc(100vh - 65px);
            background-color: #173c5b;
            padding: 20px 15px;
        }

        .sidebar .nav-link {
            color: #dceaf6;
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #315e83;
            color: white;
        }

        .sidebar .nav-link.disabled {
            color: #91b1cc;
        }

        .menu-title {
            color: #91b1cc;
            font-size: 11px;
            letter-spacing: 1px;
            padding: 10px 15px;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
        }

        .stat-icon {
            font-size: 28px;
            color: #1764a4;
        }

        .welcome-card {
            border: none;
            border-radius: 12px;
        }

        @media (max-width: 767px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark navbar-custom px-4 py-3">

    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <i class="bi bi-bank me-2"></i>
        SI-IDP Indramayu
    </a>

    <div class="d-flex align-items-center gap-3">

        <span class="text-white small">
            <i class="bi bi-person-circle me-1"></i>
            {{ auth()->user()->name }}
        </span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>

        </form>

    </div>

</nav>

<div class="container-fluid">

    <div class="row">

        <!-- Sidebar -->
        <aside class="col-md-3 col-lg-2 sidebar">

            <div class="menu-title">MENU UTAMA</div>

            <nav class="nav flex-column">

                <a class="nav-link active"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>

                <div class="menu-title">MASTER DATA</div>

                <a class="nav-link"
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

        <!-- Konten utama -->
        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="fw-bold mb-1">Dashboard</h3>

            <p class="text-muted mb-4">
                Sistem Informasi Individual Development Plan
            </p>

            <!-- Selamat datang -->
            <div class="card welcome-card shadow-sm mb-4">
                <div class="card-body p-4">

                    <h4 style="color: #123b60;">
                        Selamat datang,
                        {{ auth()->user()->name }}!
                    </h4>

                    <p class="text-muted mb-0">
                        Selamat datang di Sistem Informasi
                        Individual Development Plan
                        Pemerintah Kabupaten Indramayu.
                    </p>

                </div>
            </div>

            <!-- Statistik -->
            <div class="row g-3 mb-4">

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm">
                        <div class="card-body p-4">

                            <i class="bi bi-building stat-icon"></i>

                            <h2 class="fw-bold mt-3">
                                {{ $totalOpd }}
                            </h2>

                            <p class="text-muted mb-0">
                                Total OPD
                            </p>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm">
                        <div class="card-body p-4">

                            <i class="bi bi-check-circle stat-icon"></i>

                            <h2 class="fw-bold mt-3">
                                {{ $totalOpdAktif }}
                            </h2>

                            <p class="text-muted mb-0">
                                OPD Aktif
                            </p>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm">
                        <div class="card-body p-4">

                            <i class="bi bi-people stat-icon"></i>

                            <h2 class="fw-bold mt-3">—</h2>

                            <p class="text-muted mb-0">
                                Total PNS
                            </p>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm">
                        <div class="card-body p-4">

                            <i class="bi bi-file-earmark-text stat-icon"></i>

                            <h2 class="fw-bold mt-3">—</h2>

                            <p class="text-muted mb-0">
                                Dokumen IDP
                            </p>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Informasi sistem -->
            <div class="card welcome-card shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Informasi Sistem
                    </h5>

                    <p>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Modul Master OPD tersedia
                    </p>

                    <p>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Anda telah berhasil masuk ke SI-IDP
                    </p>

                    <p class="mb-0">
                        <i class="bi bi-clock text-warning me-2"></i>
                        Modul lainnya sedang dalam pengembangan
                    </p>

                </div>
            </div>

            <footer class="text-center text-muted small mt-5">
                &copy; {{ date('Y') }}
                BKPSDM Kabupaten Indramayu
            </footer>

        </main>

    </div>

</div>

</body>
</html>

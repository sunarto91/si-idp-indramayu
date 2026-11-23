<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard') - SI-IDP Indramayu</title>

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

        .main-content {
            min-height: calc(100vh - 72px);
        }

        .stat-card,
        .welcome-card {
            border: none;
            border-radius: 12px;
        }

        .stat-icon {
            font-size: 28px;
            color: #1764a4;
        }

        @media (min-width: 768px) {
            .sidebar {
                min-height: calc(100vh - 72px);
            }
        }
    </style>

    @stack('styles')

</head>

<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar -->
            @include('partials.sidebar')

            <!-- Konten utama -->
            <main class="col-md-9 col-lg-10 p-4 main-content d-flex flex-column">

                @yield('content')

                <!-- Footer -->
                @include('partials.footer')

            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>

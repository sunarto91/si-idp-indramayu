@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

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

@endsection

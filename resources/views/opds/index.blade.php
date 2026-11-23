@extends('layouts.app')

@section('title', 'Master OPD')

@section('content')

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active">
                Master OPD
            </li>
        </ol>
    </nav>

    <!-- Judul halaman -->
    <div class="d-flex flex-wrap justify-content-between
                align-items-center gap-3 mb-4">

        <div>
            <h3 class="fw-bold mb-1">Master OPD</h3>

            <p class="text-muted mb-0">
                Data Organisasi Perangkat Daerah
            </p>
        </div>

        <a href="{{ route('opds.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>
            Tambah OPD
        </a>

        <a href="{{ route('opds.import.create') }}"
        class="btn btn-success">
            <i class="bi bi-file-earmark-excel me-1"></i>
            Import Excel
        </a>

    </div>

    <!-- Pesan keberhasilan -->
    @if(session('success'))

        <div class="alert alert-success
                    alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <!-- Statistik -->
    <div class="row g-3 mb-4">

        <div class="col-sm-6">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-4">

                    <i class="bi bi-building stat-icon"></i>

                    <h2 class="fw-bold mt-2">
                        {{ $opds->total() }}
                    </h2>

                    <p class="text-muted mb-0">
                        Total OPD
                    </p>

                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-4">

                    <i class="bi bi-check-circle stat-icon"></i>

                    <h2 class="fw-bold mt-2">
                        {{ $opds->getCollection()
                            ->where('is_active', true)
                            ->count() }}
                    </h2>

                    <p class="text-muted mb-0">
                        OPD Aktif pada Halaman Ini
                    </p>

                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Master OPD -->
    <div class="card welcome-card shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-table me-2"></i>
                Daftar OPD
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>No.</th>
                            <th>Kode OPD</th>
                            <th>Nama OPD</th>
                            <th>Singkatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($opds as $opd)

                            <tr>

                                <td>
                                    {{ $opds->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $opd->kode_opd }}
                                </td>

                                <td>
                                    {{ $opd->nama_opd }}
                                </td>

                                <td>
                                    {{ $opd->singkatan ?? '-' }}
                                </td>

                                <td>

                                    @if($opd->is_active)

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Nonaktif
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('opds.edit', $opd) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit OPD">

                                            <i class="bi bi-pencil-square"></i>

                                            Edit

                                        </a>

                                        <form
                                            action="{{ route('opds.destroy', $opd) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus OPD ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus OPD">

                                                <i class="bi bi-trash"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-inbox fs-2"></i>

                                    <p class="mt-2 mb-0">
                                        Belum ada data OPD.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            {{ $opds->links('pagination::bootstrap-5') }}

        </div>

    </div>

@endsection

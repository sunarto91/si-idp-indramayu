
@extends('layouts.app')

@section('title', 'Preview Import OPD')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('opds.index') }}">Master OPD</a>
        </li>
        <li class="breadcrumb-item active">Preview Import</li>
    </ol>
</nav>

<div class="mb-4">
    <h3 class="fw-bold mb-1">Preview Import Excel Master OPD</h3>
    <p class="text-muted">
        Periksa data sebelum dilakukan penyimpanan ke database.
    </p>
</div>

<!-- Statistik Preview -->
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Data</h6>
                <h2>{{ $stats['total'] }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Aktif</h6>
                <h2 class="text-success">{{ $stats['aktif'] }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Nonaktif</h6>
                <h2 class="text-secondary">{{ $stats['nonaktif'] }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Perlu Pemeriksaan</h6>
                <h2 class="text-warning">
                    {{ $stats['update'] + $stats['review'] + $stats['error'] }}
                </h2>
            </div>
        </div>
    </div>

</div>

<!-- Ringkasan Hasil Pencocokan -->
<div class="alert alert-info">
    <strong>Hasil pemeriksaan database:</strong>
    <div class="mt-2">
        Data baru: {{ $stats['new'] }} |
        Kandidat pembaruan: {{ $stats['update'] }} |
        Sudah ada: {{ $stats['existing'] }} |
        Perlu review: {{ $stats['review'] }} |
        Error: {{ $stats['error'] }}
    </div>
    <div class="mt-2">
        Ini hanya preview. Belum ada data yang
        ditambahkan atau diubah pada database.
    </div>
</div>

<!-- Daftar Data Excel -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-table me-2"></i>
            Daftar Data Excel
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Baris</th>
                        <th>Kode OPD</th>
                        <th>Nama OPD</th>
                        <th>Singkatan</th>
                        <th>Status OPD</th>
                        <th>Hasil Pencocokan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rows as $item)
                        <tr>
                            <td>{{ $item['row'] }}</td>
                            <td class="text-nowrap">
                                {{ $item['kode_opd'] }}
                            </td>
                            <td>{{ $item['nama_opd'] }}</td>
                            <td>{{ $item['singkatan'] }}</td>

                            <td>
                                @if($item['is_active'] === '1')
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @elseif($item['is_active'] === '0')
                                    <span class="badge bg-secondary">
                                        Nonaktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Tidak valid
                                    </span>
                                @endif
                            </td>

                            <td>
                                @switch($item['status'])
                                    @case('new')
                                        <span class="badge bg-success">
                                            Data Baru
                                        </span>
                                        @break

                                    @case('update')
                                        <span class="badge bg-warning text-dark">
                                            Kandidat Update
                                        </span>
                                        @break

                                    @case('existing')
                                        <span class="badge bg-primary">
                                            Sudah Ada
                                        </span>
                                        @break

                                    @case('review')
                                        <span class="badge bg-warning text-dark">
                                            Perlu Review
                                        </span>
                                        @break

                                    @default
                                        <span class="badge bg-danger">
                                            Error
                                        </span>
                                @endswitch

                                @if(!empty($item['errors']))
                                    <div class="text-danger small mt-1">
                                        {{ implode(' ', $item['errors']) }}
                                    </div>
                                @endif

                                @if($item['existing_id'])
                                    <div class="text-muted small mt-1">
                                        ID existing:
                                        {{ $item['existing_id'] }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Tidak ada data yang dapat ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('opds.import.create') }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Upload Ulang
            </a>
        </div>

    </div>
</div>

@endsection

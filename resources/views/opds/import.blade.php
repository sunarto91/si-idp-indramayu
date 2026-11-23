
@extends('layouts.app')

@section('title', 'Import Excel Master OPD')

@section('content')

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('opds.index') }}">
                    Master OPD
                </a>
            </li>

            <li class="breadcrumb-item active">
                Import Excel
            </li>
        </ol>
    </nav>

    <!-- Judul Halaman -->
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            Import Excel Master OPD
        </h3>
        <p class="text-muted">
            Unggah file Excel untuk mempersiapkan
            import data Organisasi Perangkat Daerah.
        </p>
    </div>

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"
             role="alert">
            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    <!-- Form Upload -->
    <div class="card shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-file-earmark-excel me-2"></i>
                Upload File Excel
            </h5>
        </div>

        <div class="card-body p-4">

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Gunakan template Master OPD SI-IDP
                dengan format Excel (.xlsx).

                Data belum akan disimpan
                ke database pada tahap ini.
            </div>

            <form action="{{ route('opds.import.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label for="file_excel"
                           class="form-label fw-semibold">
                        Pilih File Excel
                        <span class="text-danger">*</span>
                    </label>

                    <input type="file"
                           id="file_excel"
                           name="file_excel"
                           accept=".xlsx"
                           required
                           class="form-control @error('file_excel') is-invalid @enderror">

                    @error('file_excel')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        Format yang didukung: .xlsx.
                        Ukuran maksimal: 5 MB.
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('opds.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-cloud-arrow-up me-1"></i>
                        Upload Excel
                    </button>

                </div>

            </form>
        </div>
    </div>

@endsection


@extends('layouts.app')

@section('title', 'Edit OPD')

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
                Edit OPD
            </li>
        </ol>
    </nav>

    <!-- Judul halaman -->
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Edit OPD</h3>
        <p class="text-muted">
            Perbarui data Organisasi Perangkat Daerah
        </p>
    </div>

    <!-- Form Edit -->
    <div class="card welcome-card shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                Data Organisasi Perangkat Daerah
            </h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('opds.update', $opd) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- Kode OPD -->
                    <div class="col-md-6">
                        <label for="kode_opd"
                               class="form-label">
                            Kode OPD
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               id="kode_opd"
                               name="kode_opd"
                               class="form-control @error('kode_opd') is-invalid @enderror"
                               value="{{ old('kode_opd', $opd->kode_opd) }}"
                               maxlength="30"
                               required>

                        @error('kode_opd')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Singkatan -->
                    <div class="col-md-6">
                        <label for="singkatan"
                               class="form-label">
                            Singkatan
                        </label>

                        <input type="text"
                               id="singkatan"
                               name="singkatan"
                               class="form-control @error('singkatan') is-invalid @enderror"
                               value="{{ old('singkatan', $opd->singkatan) }}"
                               maxlength="50">

                        @error('singkatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Nama OPD -->
                    <div class="col-12">
                        <label for="nama_opd"
                               class="form-label">
                            Nama OPD
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               id="nama_opd"
                               name="nama_opd"
                               class="form-control @error('nama_opd') is-invalid @enderror"
                               value="{{ old('nama_opd', $opd->nama_opd) }}"
                               maxlength="255"
                               required>

                        @error('nama_opd')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="col-12">
                        <label for="alamat"
                               class="form-label">
                            Alamat
                        </label>

                        <textarea id="alamat"
                                  name="alamat"
                                  rows="3"
                                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $opd->alamat) }}</textarea>

                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status OPD -->
                    <div class="col-md-6">
                        <label for="is_active"
                               class="form-label">
                            Status OPD
                        </label>

                        <select id="is_active"
                                name="is_active"
                                class="form-select @error('is_active') is-invalid @enderror">

                            <option value="1"
                                @selected(old('is_active', (int) $opd->is_active) == '1')>
                                Aktif
                            </option>

                            <option value="0"
                                @selected(old('is_active', (int) $opd->is_active) == '0')>
                                Nonaktif
                            </option>

                        </select>

                        @error('is_active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Tombol -->
                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('opds.index') }}"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection

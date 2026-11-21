
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit OPD - SI-IDP Indramayu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">
            SI-IDP Kabupaten Indramayu
        </span>
    </div>
</nav>

<div class="container py-5">

    <h3>Edit OPD</h3>
    <p class="text-muted">
        Perbarui data Organisasi Perangkat Daerah
    </p>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('opds.update', $opd) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode OPD *</label>
                    <input
                        type="text"
                        name="kode_opd"
                        class="form-control @error('kode_opd') is-invalid @enderror"
                        value="{{ old('kode_opd', $opd->kode_opd) }}"
                        maxlength="30"
                        required>

                    @error('kode_opd')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama OPD *</label>
                    <input
                        type="text"
                        name="nama_opd"
                        class="form-control @error('nama_opd') is-invalid @enderror"
                        value="{{ old('nama_opd', $opd->nama_opd) }}"
                        maxlength="255"
                        required>

                    @error('nama_opd')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Singkatan</label>
                    <input
                        type="text"
                        name="singkatan"
                        class="form-control @error('singkatan') is-invalid @enderror"
                        value="{{ old('singkatan', $opd->singkatan) }}"
                        maxlength="50">

                    @error('singkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea
                        name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $opd->alamat) }}</textarea>

                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1"
                            @selected(old('is_active', (int) $opd->is_active) == '1')>
                            Aktif
                        </option>
                        <option value="0"
                            @selected(old('is_active', (int) $opd->is_active) == '0')>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('opds.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>

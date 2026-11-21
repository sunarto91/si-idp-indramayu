
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Master OPD - SI-IDP Indramayu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Master OPD</h3>
            <p class="text-muted">
                Data Organisasi Perangkat Daerah
            </p>
        </div>

        <a href="{{ route('opds.create') }}"
           class="btn btn-primary">
            + Tambah OPD
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-striped table-hover">
                <thead class="table-dark">
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

                            <td>{{ $opd->kode_opd }}</td>
                            <td>{{ $opd->nama_opd }}</td>
                            <td>{{ $opd->singkatan ?? '-' }}</td>

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
                                <a href="{{ route('opds.edit', $opd) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('opds.destroy', $opd) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin menghapus OPD ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Belum ada data OPD.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $opds->links('pagination::bootstrap-5') }}

        </div>
    </div>
</div>

</body>
</html>

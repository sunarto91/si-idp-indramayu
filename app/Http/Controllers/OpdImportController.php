<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Opd;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;


class OpdImportController extends Controller
{
    /**
     * Menampilkan halaman upload Excel.
     */
    public function create()
    {
        return view('opds.import');
    }

    /**
     * Memvalidasi dan menyimpan file sementara.
     * Belum memasukkan data ke tabel opds.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_excel' => [
                'required',
                'file',
                'mimes:xlsx',
                'max:5120',
            ],
        ], [
            'file_excel.required' =>
                'Silakan pilih file Excel terlebih dahulu.',

            'file_excel.file' =>
                'File yang diunggah tidak valid.',

            'file_excel.mimes' =>
                'File harus berformat Excel (.xlsx).',

            'file_excel.max' =>
                'Ukuran file maksimal 5 MB.',
        ]);

        // Hapus file sementara dari upload sebelumnya.
        $oldPath = $request->session()->get('opd_import_path');

        if ($oldPath) {
            Storage::disk('local')->delete($oldPath);
        }

        // Simpan secara privat dengan nama acak.
        $path = $request->file('file_excel')->store(
            'imports/opds',
            'local'
        );

        if (!$path) {
            return back()->withErrors([
                'file_excel' =>
                    'Gagal menyimpan file sementara.',
            ]);
        }

        // Simpan lokasi file dalam session.
        $request->session()->put('opd_import_path', $path);

        return redirect()
            ->route('opds.import.preview')
            ->with(
                'success',
                'File Excel berhasil diunggah. '
                . 'Data belum disimpan ke database.'
            );
    }



/**
 * Membaca Excel dan menampilkan preview.
 * Tidak mengubah database.
 */
public function preview(Request $request)
{
    $path = $request->session()->get('opd_import_path');

    if (!$path || !Storage::disk('local')->exists($path)) {
        return redirect()
            ->route('opds.import.create')
            ->withErrors([
                'file_excel' => 'Silakan unggah file Excel terlebih dahulu.',
            ]);
    }

    try {
        $file = Storage::disk('local')->path($path);

        // Baca Excel tanpa memuat format tampilannya.
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);

        // Periksa nama-nama worksheet sebelum membaca file.
        $sheetNames = $reader->listWorksheetNames($file);

        // Cari worksheet yang bernama Siap_Import.
        $sheetName = collect($sheetNames)->first(
            fn ($name) => trim($name) === 'Siap_Import'
        );

        if (!$sheetName) {
            throw new \RuntimeException(
                'Sheet Siap_Import tidak ditemukan. ' .
                'Sheet tersedia: ' . implode(', ', $sheetNames)
            );
        }

        // Muat hanya worksheet yang sudah ditemukan.
        $reader->setLoadSheetsOnly([$sheetName]);

        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getSheetByName($sheetName);

        if (!$sheet) {
            throw new \RuntimeException(
                'Worksheet gagal dimuat: ' . $sheetName
            );
        }


        // Header template harus berada di baris 4.
        $expected = [
            'kode_opd',
            'nama_opd',
            'singkatan',
            'alamat',
            'is_active',
        ];

        foreach ($expected as $index => $header) {
            $column = chr(65 + $index);

            $actual = trim((string) $sheet
                ->getCell($column . '4')
                ->getValue());

            if ($actual !== $header) {
                throw new \RuntimeException('Format kolom Excel tidak sesuai.');
            }
        }

        $lastRow = $sheet->getHighestDataRow();

        if ($lastRow > 1004) {
            throw new \RuntimeException('Maksimal 1.000 baris data per file.');
        }

        $data = $lastRow >= 5
            ? $sheet->rangeToArray(
                'A5:E' . $lastRow,
                null,
                false,
                false,
                true
            )
            : [];

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        $existing = Opd::all();
        $rows = [];
        $seenCodes = [];
        $seenNames = [];

        // Normalisasi nama untuk perbandingan.
        $normalize = static function ($value) {
            $value = preg_replace(
                '/\s*\([^)]*\)/u',
                '',
                (string) $value
            );

            return Str::lower(
                trim(preg_replace('/\s+/u', ' ', $value))
            );
        };

        foreach ($data as $number => $item) {

            $kode = trim((string) ($item['A'] ?? ''));
            $nama = trim((string) ($item['B'] ?? ''));
            $singkatan = trim((string) ($item['C'] ?? ''));
            $alamat = trim((string) ($item['D'] ?? ''));
            $aktif = $item['E'] ?? null;

            // Lewati baris yang seluruh kolomnya kosong.
            if (
                $kode === '' &&
                $nama === '' &&
                $singkatan === '' &&
                $alamat === '' &&
                ($aktif === null || $aktif === '')
            ) {
                continue;
            }

            $errors = [];

            if ($kode === '' || mb_strlen($kode) > 30) {
                $errors[] = 'Kode OPD kosong atau terlalu panjang.';
            }

            if ($nama === '' || mb_strlen($nama) > 255) {
                $errors[] = 'Nama OPD kosong atau terlalu panjang.';
            }

            if (mb_strlen($singkatan) > 50) {
                $errors[] = 'Singkatan terlalu panjang.';
            }

            if (
                !in_array((string) $aktif, ['0', '1'], true)
            ) {
                $errors[] = 'Status harus 0 atau 1.';
            }

            // Cek duplikasi dalam file Excel.
            $kodeKey = Str::lower($kode);
            $namaKey = $normalize($nama);

            if ($kode !== '' && isset($seenCodes[$kodeKey])) {
                $errors[] = 'Kode duplikat dalam Excel.';
            }

            if ($nama !== '' && isset($seenNames[$namaKey])) {
                $errors[] = 'Nama duplikat dalam Excel.';
            }

            if ($kode !== '') {
                $seenCodes[$kodeKey] = true;
            }

            if ($nama !== '') {
                $seenNames[$namaKey] = true;
            }

            // Cek data pada MySQL.
            $byCode = $existing->first(
                fn ($opd) =>
                    Str::lower((string) $opd->kode_opd) === $kodeKey
            );

            $byName = $existing->first(
                fn ($opd) =>
                    $normalize($opd->nama_opd) === $namaKey
            );

            // Jika kode dan nama merujuk ke ID berbeda,
            // tandai sebagai konflik.
            if (
                $byCode &&
                $byName &&
                $byCode->id !== $byName->id
            ) {
                $errors[] = 'Konflik: kode dan nama merujuk ke OPD berbeda.';
            }

            if (!empty($errors)) {
                $status = 'error';
            } elseif ($byCode && $byName && $byCode->id === $byName->id) {
                $status = 'existing';
            } elseif ($byCode && !$byName) {
                // Kode sama, nama berbeda: perlu review.
                $status = 'review';
            } elseif ($byName && !$byCode) {
                // Nama sama, kode berubah: kandidat update.
                $status = 'update';
            } else {
                $status = 'new';
            }

            $rows[] = [
                'row' => $number,
                'kode_opd' => $kode,
                'nama_opd' => $nama,
                'singkatan' => $singkatan,
                'alamat' => $alamat,
                'is_active' => (string) $aktif,
                'status' => $status,
                'existing_id' => $byCode?->id ?? $byName?->id,
                'errors' => $errors,
            ];
        }

        $stats = [
            'total' => count($rows),
            'aktif' => collect($rows)->where('is_active', '1')->count(),
            'nonaktif' => collect($rows)->where('is_active', '0')->count(),
            'new' => collect($rows)->where('status', 'new')->count(),
            'update' => collect($rows)->where('status', 'update')->count(),
            'existing' => collect($rows)->where('status', 'existing')->count(),
            'review' => collect($rows)->where('status', 'review')->count(),
            'error' => collect($rows)->where('status', 'error')->count(),
        ];

        return view('opds.preview', compact('rows', 'stats'));

    } catch (\Throwable $e) {
        Log::error('Gagal membaca Excel OPD', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->route('opds.import.create')
            ->withErrors([
                'file_excel' =>
                    'File Excel tidak dapat dibaca. ' .
                    'Pastikan menggunakan template SI-IDP ' .
                    'dengan sheet Siap_Import.',
            ]);
    }
}


/**
 * Konfirmasi dan simpan data OPD dari Excel.
 *
 * Khusus impor awal 61 OPD Kabupaten Indramayu.
 * Tidak mengubah data lama dan tidak mengizinkan
 * impor jika tabel opds sudah berisi data.
 */
public function confirm(Request $request)
{
    // 1. Ambil file upload dari session.
    $path = $request->session()->get('opd_import_path');

    if (
        !$path ||
        !Str::startsWith($path, 'imports/opds/') ||
        !Storage::disk('local')->exists($path)
    ) {
        return redirect()
            ->route('opds.import.create')
            ->withErrors([
                'file_excel' => 'File Excel tidak ditemukan. Silakan upload ulang.',
            ]);
    }

    $spreadsheet = null;

    try {
        // 2. Pastikan database masih kosong.
        if (Opd::query()->exists()) {
            return redirect()
                ->route('opds.import.preview')
                ->withErrors([
                    'import' => 'Import awal dibatalkan karena tabel OPD sudah berisi data.',
                ]);
        }

        // 3. Baca ulang file Excel dari penyimpanan privat.
        $file = Storage::disk('local')->path($path);

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);

        $sheetNames = $reader->listWorksheetNames($file);

        if (!in_array('Siap_Import', $sheetNames, true)) {
            throw new \RuntimeException(
                'Worksheet Siap_Import tidak ditemukan.'
            );
        }

        $reader->setLoadSheetsOnly(['Siap_Import']);

        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getSheetByName('Siap_Import');

        if (!$sheet) {
            throw new \RuntimeException('Worksheet gagal dimuat.');
        }

        // 4. Validasi header pada baris 4.
        $headers = [
            'kode_opd',
            'nama_opd',
            'singkatan',
            'alamat',
            'is_active',
        ];

        foreach ($headers as $index => $header) {
            $column = chr(65 + $index);

            $actual = trim(
                (string) $sheet->getCell($column . '4')->getValue()
            );

            if ($actual !== $header) {
                throw new \RuntimeException(
                    'Header Excel tidak sesuai pada kolom ' . $column
                );
            }
        }

        $lastRow = $sheet->getHighestDataRow();

        if ($lastRow < 5 || $lastRow > 1004) {
            throw new \RuntimeException(
                'Jumlah baris Excel tidak valid.'
            );
        }

        $excelRows = $sheet->rangeToArray(
            'A5:E' . $lastRow,
            null,
            false,
            false,
            true
        );

        $data = [];
        $seenCodes = [];
        $seenNames = [];

        // 5. Validasi setiap baris Excel.
        foreach ($excelRows as $rowNumber => $row) {
            $kode = trim((string) ($row['A'] ?? ''));
            $nama = trim((string) ($row['B'] ?? ''));
            $singkatan = trim((string) ($row['C'] ?? ''));
            $alamat = trim((string) ($row['D'] ?? ''));
            $status = trim((string) ($row['E'] ?? ''));

            // Abaikan hanya baris yang seluruhnya kosong.
            if (
                $kode === '' &&
                $nama === '' &&
                $singkatan === '' &&
                $alamat === '' &&
                $status === ''
            ) {
                continue;
            }

            if (
                $kode === '' ||
                mb_strlen($kode) > 30 ||
                $nama === '' ||
                mb_strlen($nama) > 255 ||
                mb_strlen($singkatan) > 50 ||
                !in_array($status, ['0', '1'], true)
            ) {
                throw new \RuntimeException(
                    'Data tidak valid pada baris ' . $rowNumber
                );
            }

            $codeKey = Str::lower($kode);
            $nameKey = Str::lower(
                trim(preg_replace('/\s+/u', ' ', $nama))
            );

            if (
                isset($seenCodes[$codeKey]) ||
                isset($seenNames[$nameKey])
            ) {
                throw new \RuntimeException(
                    'Duplikasi kode atau nama pada baris ' . $rowNumber
                );
            }

            $seenCodes[$codeKey] = true;
            $seenNames[$nameKey] = true;

            $data[] = [
                'kode_opd' => $kode,
                'nama_opd' => $nama,
                'singkatan' => $singkatan === '' ? null : $singkatan,
                'alamat' => $alamat === '' ? null : $alamat,
                'is_active' => (int) $status,
            ];
        }

        // 6. Validasi khusus dataset awal Indramayu.
        if (count($data) !== 61) {
            throw new \RuntimeException(
                'File harus berisi tepat 61 OPD.'
            );
        }

        $aktif = collect($data)->where('is_active', 1)->count();
        $nonaktif = collect($data)->where('is_active', 0)->count();

        if ($aktif !== 60 || $nonaktif !== 1) {
            throw new \RuntimeException(
                'Jumlah status aktif/nonaktif tidak sesuai.'
            );
        }

        // Pastikan hanya RSUD Sentot yang nonaktif.
        $inactiveOpds = collect($data)
            ->where('is_active', 0);

        if (
            $inactiveOpds->first()['nama_opd']
            !== 'RSUD Pantura M.A. Sentot Patrol'
        ) {
            throw new \RuntimeException(
                'OPD nonaktif harus RSUD Pantura M.A. Sentot Patrol.'
            );
        }

        // Pastikan kode BKPSDM mengikuti Excel resmi.
        $bkpsdm = collect($data)->firstWhere(
            'kode_opd',
            '5.03.5.04.0.00.01.0000'
        );

        if (
            !$bkpsdm ||
            $bkpsdm['singkatan'] !== 'BKPSDM'
        ) {
            throw new \RuntimeException(
                'Kode BKPSDM tidak sesuai template sumber.'
            );
        }

        // 7. Simpan semua baris dalam satu transaksi.
        DB::transaction(function () use ($data) {

            // Cek ulang di dalam transaksi.
            if (Opd::query()->exists()) {
                throw new \RuntimeException(
                    'Tabel OPD sudah berisi data. Import dibatalkan.'
                );
            }

            foreach ($data as $item) {
                Opd::create($item);
            }
        });

        // 8. Hapus file sementara setelah berhasil.
        Storage::disk('local')->delete($path);
        $request->session()->forget('opd_import_path');

        return redirect()
            ->route('opds.index')
            ->with(
                'success',
                'Import berhasil! 61 data OPD telah disimpan ke database.'
            );

    } catch (\Throwable $e) {

        Log::error('Gagal konfirmasi import OPD', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->route('opds.import.preview')
            ->withErrors([
                'import' => 'Import dibatalkan: ' . $e->getMessage(),
            ]);

    } finally {
        if ($spreadsheet !== null) {
            $spreadsheet->disconnectWorksheets();
        }
    }
}


}

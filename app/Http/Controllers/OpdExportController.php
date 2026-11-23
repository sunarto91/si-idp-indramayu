<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OpdExportController extends Controller
{
    public function export(Request $request)
    {
        // 1. Validasi parameter filter
        $filters = $request->validate([
            'search' => 'nullable|string|max:100',
            'status' => 'nullable|in:0,1',
        ]);

        $search = trim($filters['search'] ?? '');
        $status = $filters['status'] ?? '';

        // 2. Query OPD dari database
        $query = Opd::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kode_opd', 'like', '%' . $search . '%')
                  ->orWhere('nama_opd', 'like', '%' . $search . '%')
                  ->orWhere('singkatan', 'like', '%' . $search . '%');
            });
        }

        if ($status !== '') {
            $query->where('is_active', (int) $status);
        }

        // Export seluruh hasil filter, bukan hanya 10
        // data yang terlihat pada halaman pagination.
        $opds = $query->orderBy('id', 'asc')->get();

        // 3. Buat workbook Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Master_OPD');

        // 4. Header tabel
        $headers = [
            'kode_opd',
            'nama_opd',
            'singkatan',
            'alamat',
            'is_active',
        ];

        foreach ($headers as $index => $header) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '1', $header);
        }

        // 5. Isi data OPD
        $rowNumber = 2;

        foreach ($opds as $opd) {
            // Gunakan tipe STRING agar kode OPD
            // tidak berubah menjadi format angka.
            // Ini juga mencegah teks diawali "="
            // ditafsirkan sebagai formula Excel.
            $sheet->setCellValueExplicit(
                'A' . $rowNumber,
                (string) $opd->kode_opd,
                DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'B' . $rowNumber,
                (string) $opd->nama_opd,
                DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'C' . $rowNumber,
                (string) ($opd->singkatan ?? ''),
                DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'D' . $rowNumber,
                (string) ($opd->alamat ?? ''),
                DataType::TYPE_STRING
            );

            // Status numerik agar kompatibel
            // dengan template Import SI-IDP.
            $sheet->setCellValue(
                'E' . $rowNumber,
                $opd->is_active ? 1 : 0
            );

            $rowNumber++;
        }

        // 6. Format header
        $sheet->getStyle('A1:E1')->getFont()
            ->setBold(true)
            ->getColor()->setARGB('FFFFFFFF');

        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF173B60');

        $sheet->getStyle('A1:E1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 7. Atur lebar dan tampilan kolom
        $sheet->getColumnDimension('A')->setWidth(29);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(26);
        $sheet->getColumnDimension('D')->setWidth(65);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->getStyle('A1:E' . max(1, $rowNumber - 1))
            ->getAlignment()->setWrapText(true);

        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:E1');

        // 8. Nama file berdasarkan tanggal
        $filename = 'Master_OPD_Indramayu_'
            . now()->format('Y-m-d_His')
            . '.xlsx';

        // 9. Kirim file sebagai download
        return response()->streamDownload(
            function () use ($spreadsheet) {
                try {
                    $writer = new Xlsx($spreadsheet);
                    $writer->save('php://output');
                } finally {
                    $spreadsheet->disconnectWorksheets();
                }
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'no-store',
            ]
        );
    }
}

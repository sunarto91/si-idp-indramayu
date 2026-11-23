<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OpdController extends Controller
{
    // Menampilkan daftar OPD
    public function index()
    {
        $opds = Opd::orderBy('nama_opd')->paginate(10);

        return view('opds.index', compact('opds'));
    }

    // Menampilkan formulir tambah OPD
    public function create()
    {
        return view('opds.create');
    }

    // Menyimpan OPD baru
    public function store(Request $request)
    {
    $data = $request->validate([
        'kode_opd' => 'required|string|max:30|unique:opds,kode_opd',
        'nama_opd' => 'required|string|max:255',
        'singkatan' => 'nullable|string|max:50',
        'alamat' => 'nullable|string',
        'is_active' => 'required|boolean',
        ], [
            'kode_opd.required' => 'Kode OPD wajib diisi.',
            'kode_opd.unique' => 'Kode OPD sudah digunakan. Silakan masukkan kode yang berbeda.',
            'kode_opd.max' => 'Kode OPD maksimal 30 karakter.',

            'nama_opd.required' => 'Nama OPD wajib diisi.',
            'nama_opd.max' => 'Nama OPD maksimal 255 karakter.',

            'singkatan.max' => 'Singkatan maksimal 50 karakter.',
            'is_active.required' => 'Status OPD wajib dipilih.',
            'is_active.boolean' => 'Status OPD tidak valid.',
    ]);

        Opd::create($data);

        return redirect()
            ->route('opds.index')
            ->with('success', 'OPD berhasil ditambahkan.');
    }

    // Menampilkan detail melalui halaman edit
    public function show(Opd $opd)
    {
        return redirect()->route('opds.edit', $opd);
    }

    // Menampilkan formulir edit
    public function edit(Opd $opd)
    {
        return view('opds.edit', compact('opd'));
    }

    // Memperbarui data OPD
    public function update(Request $request, Opd $opd)
    {
        $data = $request->validate([
            'kode_opd' => [
                'required',
                'string',
                'max:30',
                Rule::unique('opds', 'kode_opd')->ignore($opd->id),
            ],
            'nama_opd' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $opd->update($data);

        return redirect()
            ->route('opds.index')
            ->with('success', 'OPD berhasil diperbarui.');
    }

    // Menghapus OPD
    public function destroy(Opd $opd)
    {
        $opd->delete();

        return redirect()
            ->route('opds.index')
            ->with('success', 'OPD berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Opd;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOpd = Opd::count();

        $totalOpdAktif = Opd::where('is_active', true)->count();

        return view('dashboard', compact(
            'totalOpd',
            'totalOpdAktif'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $totalPelanggan = Pelanggan::count();
        $totalTransaksi = Transaksi::count();

        return view('dashboard', [
            'totalPelanggan' => $totalPelanggan,
            'totalTransaksi' => $totalTransaksi,
        ]);
    }
}
?>
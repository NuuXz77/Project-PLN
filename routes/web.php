<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Pembayaran;

Route::view('/', 'welcome');

// ✅ Dashboard (untuk semua yang login dan terverifikasi)
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Profile (akses umum semua role yang login)
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// ✅ Group untuk ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('petugas', 'users')->name('users'); // CRUD user // CRUD pelanggan
    Route::view('tarif', 'tarif')->name('tarif');           // CRUD tarif
    Route::view('laporan-pelanggan', 'laporan.laporan-pelanggan')->name('laporan-pelanggan');           // CRUD tarif
    Route::view('laporan-transaksi', 'laporan.laporan-transaksi')->name('laporan-pelanggan');           // CRUD tarif

});

// ✅ Group untuk PETUGAS LOKET
Route::middleware(['auth', 'role:loket'])->group(function () {
    Route::view('pelanggan', 'pelanggan')->name('pelanggan');   // CRUD pelanggan
    Route::view('pemakaian', 'pemakaian')->name('pemakaian');   // CRUD pemakaian
    Route::view('pembayaran', 'pembayaran')->name('pembayaran'); // CRUD pembayaran
    Route::view('transaksi', 'transaksi')->name('transaksi'); // CRUD transaksi

    // Print transaksi (asumsi hanya admin boleh print)
    Route::get('/transaksi/print/{id}', function ($id) {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggan = Pelanggan::where('No_Kontrol', $transaksi->No_Kontrol)->first();
        $pemakaian = $transaksi->No_Pemakaian ? Pemakaian::where('No_Pemakaian', $transaksi->No_Pemakaian)->first() : null;
        $pembayaran = Pembayaran::where('No_Kontrol', $transaksi->No_Kontrol)
            ->where('No_Pembayaran', $transaksi->No_Transaksi)
            ->first();

        return view('transaksi.print', [
            'transaksi' => $transaksi,
            'pelanggan' => $pelanggan,
            'pemakaian' => $pemakaian,
            'pembayaran' => $pembayaran
        ]);
    })->name('print');
});

require __DIR__ . '/auth.php';

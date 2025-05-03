<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Pembayaran;


Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('pelanggan', 'pelanggan')
    ->middleware(['auth'])
    ->name('pelanggan');

Route::view('pemakaian', 'pemakaian')
    ->middleware(['auth'])
    ->name('pemakaian');

Route::view('tarif', 'tarif')
    ->middleware(['auth'])
    ->name('tarif');

Route::view('pembayaran', 'pembayaran')
    ->middleware(['auth'])
    ->name('pembayaran');

Route::view('transaksi', 'transaksi')
    ->middleware(['auth'])
    ->name('transaksi');

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

require __DIR__ . '/auth.php';

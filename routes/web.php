<?php

use App\Livewire\PelangganPage;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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
    
require __DIR__.'/auth.php';

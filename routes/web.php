<?php

use App\Livewire\PelangganPage;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
Route::view('pelanggan', 'pelanggan')
    ->middleware(['auth'])
    ->name('pelanggan');
    
require __DIR__.'/auth.php';

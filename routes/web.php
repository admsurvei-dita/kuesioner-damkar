<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
use App\Livewire\AdminDashboard;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/command-center', AdminDashboard::class)
        ->name('admin.dashboard')
        ->middleware('can:admin-access'); // Proteksi menggunakan Gate admin-access
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

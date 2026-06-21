<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Home page (tidak perlu login)
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (login/register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Dashboard (hanya untuk user yang sudah login)
Route::get('/dashboard', function () {
    $announcements = \App\Models\Announcement::orderBy('created_at', 'desc')->get();
    return view('dashboard', compact('announcements'));
})->middleware('auth')->name('dashboard');

// Logout (hanya untuk user yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AdminController;

Route::middleware('auth')->group(function () {
    // Student Routes
    Route::get('/mata-kuliah', [MahasiswaController::class, 'mataKuliah'])->name('mata-kuliah');
    Route::get('/tugas',       [MahasiswaController::class, 'tugas'])->name('tugas');
    Route::get('/nilai',       [MahasiswaController::class, 'nilai'])->name('nilai');
    Route::get('/materi',      [MahasiswaController::class, 'materi'])->name('materi');
    Route::get('/materi/download/{id}', [MahasiswaController::class, 'downloadMateri'])->name('materi.download');

    // Upload tugas
    Route::post('/tugas/upload', [MahasiswaController::class, 'uploadTugas'])->name('tugas.upload');
    // Download tugas
    Route::get('/tugas/download/{id}', [MahasiswaController::class, 'downloadTugas'])->name('tugas.download');

    // Dosen Routes
    Route::get('/dosen/mata-kuliah',   [DosenController::class, 'mataKuliah'])->name('dosen.mata-kuliah');
    Route::get('/dosen/tugas',         [DosenController::class, 'tugas'])->name('dosen.tugas');
    Route::post('/dosen/tugas/store',  [DosenController::class, 'storeTugas'])->name('dosen.tugas.store');
    Route::get('/dosen/nilai',         [DosenController::class, 'nilai'])->name('dosen.nilai');
    Route::post('/dosen/nilai/store',  [DosenController::class, 'storeNilai'])->name('dosen.nilai.store');
    Route::post('/dosen/presensi/store', [DosenController::class, 'storePresensi'])->name('dosen.presensi.store');
    Route::post('/dosen/nilai/store-pertemuan', [DosenController::class, 'storeNilaiPertemuan'])->name('dosen.nilai.store-pertemuan');
    Route::get('/dosen/materi',        [DosenController::class, 'materi'])->name('dosen.materi');
    Route::post('/dosen/materi/store', [DosenController::class, 'storeMateri'])->name('dosen.materi.store');
    Route::post('/dosen/materi/delete/{id}', [DosenController::class, 'destroyMateri'])->name('dosen.materi.delete');
    
    // New Dosen routes
    Route::get('/dosen/mahasiswa',     [DosenController::class, 'mahasiswa'])->name('dosen.mahasiswa');
    Route::post('/dosen/nilai/import', [DosenController::class, 'importNilai'])->name('dosen.nilai.import');
    Route::get('/dosen/jurnal-rps',    [DosenController::class, 'jurnalRps'])->name('dosen.jurnal-rps');
    Route::post('/dosen/rps/import',   [DosenController::class, 'importRps'])->name('dosen.rps.import');
    Route::post('/dosen/jurnal/store', [DosenController::class, 'storeJurnal'])->name('dosen.jurnal.store');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
        Route::post('/users/update/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::post('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Kelas Management
        Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');
        
        // Mata Kuliah (CRUD)
        Route::post('/matakuliah/store', [AdminController::class, 'storeMataKuliah'])->name('matakuliah.store');
        Route::post('/matakuliah/update/{id}', [AdminController::class, 'updateMataKuliah'])->name('matakuliah.update');
        Route::post('/matakuliah/delete/{id}', [AdminController::class, 'deleteMataKuliah'])->name('matakuliah.delete');
        
        // Tugas Management
        Route::post('/tugas/store', [AdminController::class, 'storeTugas'])->name('tugas.store');
        Route::post('/tugas/update/{id}', [AdminController::class, 'updateTugas'])->name('tugas.update');
        Route::post('/tugas/delete/{id}', [AdminController::class, 'deleteTugas'])->name('tugas.delete');
        
        // Nilai Management
        Route::post('/nilai/store', [AdminController::class, 'storeNilai'])->name('nilai.store');
        Route::post('/nilai/update/{id}', [AdminController::class, 'updateNilai'])->name('nilai.update');
        Route::post('/nilai/delete/{id}', [AdminController::class, 'deleteNilai'])->name('nilai.delete');

        // Materi Management
        Route::post('/materi/store', [AdminController::class, 'storeMateri'])->name('materi.store');
        Route::post('/materi/update/{id}', [AdminController::class, 'updateMateri'])->name('materi.update');
        Route::post('/materi/delete/{id}', [AdminController::class, 'deleteMateri'])->name('materi.delete');

        // Pengumuman Management
        Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');
        Route::post('/pengumuman/store', [AdminController::class, 'storeAnnouncement'])->name('pengumuman.store');
        Route::post('/pengumuman/update/{id}', [AdminController::class, 'updateAnnouncement'])->name('pengumuman.update');
        Route::post('/pengumuman/delete/{id}', [AdminController::class, 'deleteAnnouncement'])->name('pengumuman.delete');
        
        // New Admin routes
        Route::get('/mahasiswa',           [AdminController::class, 'mahasiswa'])->name('mahasiswa');
        Route::post('/nilai/import',       [AdminController::class, 'importNilai'])->name('nilai.import');
        Route::get('/jurnal-rps',          [AdminController::class, 'jurnalRps'])->name('jurnal-rps');
        Route::post('/rps/import',         [AdminController::class, 'importRps'])->name('rps.import');
        Route::post('/jurnal/store',       [AdminController::class, 'storeJurnal'])->name('jurnal.store');
    });

    // Global Announcement file download
    Route::get('/announcements/download/{id}', [AdminController::class, 'downloadAnnouncement'])->name('announcements.download');
});

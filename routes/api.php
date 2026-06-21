<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

// Public login route
Route::post('/login', [ApiController::class, 'login']);

// Protected routes (Needs "Authorization: Bearer <token>" header)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mata-kuliah', [ApiController::class, 'getMataKuliah']);
    Route::get('/tugas', [ApiController::class, 'getTugas']);
    Route::get('/announcements', [ApiController::class, 'getAnnouncements']);
    Route::post('/announcements', [ApiController::class, 'createAnnouncement']);
    Route::put('/announcements/{id}', [ApiController::class, 'updateAnnouncement']);
    Route::delete('/announcements/{id}', [ApiController::class, 'deleteAnnouncement']);
});

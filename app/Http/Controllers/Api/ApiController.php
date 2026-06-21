<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\TugasDosen;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * POST /api/login
     * Authenticate user and return token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        $user = Auth::user();
        
        // Revoke old tokens if any to keep database clean
        $user->tokens()->delete();
        
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token
            ]
        ], 200);
    }

    /**
     * GET /api/mata-kuliah
     * Retrieve all courses.
     */
    public function getMataKuliah()
    {
        $mataKuliah = MataKuliah::all();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar mata kuliah.',
            'data' => $mataKuliah
        ], 200);
    }

    /**
     * GET /api/tugas
     * Retrieve all tasks.
     */
    public function getTugas()
    {
        $tugas = TugasDosen::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar tugas dosen.',
            'data' => $tugas
        ], 200);
    }

    /**
     * GET /api/announcements
     * Retrieve all announcements.
     */
    public function getAnnouncements()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar pengumuman.',
            'data' => $announcements
        ], 200);
    }

    /**
     * POST /api/announcements
     * Create a new announcement.
     */
    public function createAnnouncement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul pengumuman harus diisi.',
            'content.required' => 'Isi pengumuman harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $request->file_path ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil dibuat.',
            'data' => $announcement
        ], 201);
    }

    /**
     * PUT /api/announcements/{id}
     * Update an announcement.
     */
    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul pengumuman harus diisi.',
            'content.required' => 'Isi pengumuman harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $request->file_path ?? $announcement->file_path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil diperbarui.',
            'data' => $announcement
        ], 200);
    }

    /**
     * DELETE /api/announcements/{id}
     * Delete an announcement.
     */
    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan.'
            ], 404);
        }

        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil dihapus.'
        ], 200);
    }
}

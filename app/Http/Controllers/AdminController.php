<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Tugas;
use App\Models\TugasDosen;
use App\Models\Nilai;
use App\Models\Materi;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses tidak sah untuk peran Anda.');
        }
    }

    // ==========================================
    // MANAJEMEN USER
    // ==========================================
    public function users()
    {
        $this->checkAdmin();
        $users = User::orderBy('role', 'asc')->orderBy('name', 'asc')->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,dosen,mahasiswa',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,dosen,mahasiswa',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Data user berhasil diperbarui!');
    }

    public function deleteUser($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus diri sendiri!']);
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    // ==========================================
    // MANAJEMEN KELAS (Mata Kuliah, Tugas, Nilai, Materi)
    // ==========================================
    public function kelas()
    {
        $this->checkAdmin();
        $mataKuliah = MataKuliah::all();
        $tugasDosen = TugasDosen::orderBy('created_at', 'desc')->get();
        $tugasMahasiswa = Tugas::with('user')->orderBy('created_at', 'desc')->get();
        $nilaiList = Nilai::with('user')->orderBy('mata_kuliah', 'asc')->get();
        $materiList = Materi::orderBy('mata_kuliah', 'asc')->orderBy('pertemuan', 'asc')->get();
        
        $dosen = User::where('role', 'dosen')->get();
        $mahasiswa = User::where('role', 'mahasiswa')->get();

        return view('admin.kelas', compact(
            'mataKuliah', 'tugasDosen', 'tugasMahasiswa', 'nilaiList', 'materiList', 'dosen', 'mahasiswa'
        ));
    }

    // --- Mata Kuliah CRUD ---
    public function storeMataKuliah(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_kuliah',
            'sks' => 'required|integer|min:1|max:6',
            'dosen' => 'required|string',
        ]);

        MataKuliah::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'sks' => $request->sks,
            'dosen' => $request->dosen,
        ]);

        return back()->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function updateMataKuliah(Request $request, $id)
    {
        $this->checkAdmin();
        $mk = MataKuliah::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_kuliah,kode,' . $id,
            'sks' => 'required|integer|min:1|max:6',
            'dosen' => 'required|string',
        ]);

        $mk->update($request->all());

        return back()->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function deleteMataKuliah($id)
    {
        $this->checkAdmin();
        MataKuliah::destroy($id);
        return back()->with('success', 'Mata Kuliah berhasil dihapus!');
    }

    // --- Tugas CRUD ---
    public function storeTugas(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'judul' => 'required|string|max:255',
            'penjelasan' => 'required|string',
            'mata_kuliah' => 'required|string',
            'deadline' => 'required|date',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tugas_dosen', 'public');
        }

        TugasDosen::create([
            'judul' => $request->judul,
            'penjelasan' => $request->penjelasan,
            'mata_kuliah' => $request->mata_kuliah,
            'deadline' => $request->deadline,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function updateTugas(Request $request, $id)
    {
        $this->checkAdmin();
        $tugas = TugasDosen::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'penjelasan' => 'required|string',
            'mata_kuliah' => 'required|string',
            'deadline' => 'required|date',
            'file' => 'nullable|file|max:10240',
        ]);

        $data = $request->except('file');
        if ($request->hasFile('file')) {
            if ($tugas->file_path && Storage::disk('public')->exists($tugas->file_path)) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $data['file_path'] = $request->file('file')->store('tugas_dosen', 'public');
        }

        $tugas->update($data);

        return back()->with('success', 'Tugas berhasil diperbarui!');
    }

    public function deleteTugas($id)
    {
        $this->checkAdmin();
        $tugas = TugasDosen::findOrFail($id);
        if ($tugas->file_path && Storage::disk('public')->exists($tugas->file_path)) {
            Storage::disk('public')->delete($tugas->file_path);
        }
        $tugas->delete();
        return back()->with('success', 'Tugas berhasil dihapus!');
    }

    // --- Nilai CRUD ---
    public function storeNilai(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mata_kuliah' => 'required|string',
            'nilai_presensi' => 'nullable|numeric|min:0|max:100',
            'nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai_uts' => 'nullable|numeric|min:0|max:100',
            'nilai_uas' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilaiPresensi = $request->nilai_presensi ?? 0;
        $nilaiTugas = $request->nilai_tugas ?? 0;
        $nilaiKeaktifan = $nilaiTugas; // Keaktifan menyatu dengan tugas
        $nilaiUTS = $request->nilai_uts ?? 0;
        $nilaiUAS = $request->nilai_uas ?? 0;

        $totalNilai = ($nilaiPresensi * 0.20) + ($nilaiTugas * 0.20) + ($nilaiUTS * 0.25) + ($nilaiUAS * 0.35);

        if ($totalNilai >= 85.01) {
            $akreditasi = 'A';
        } elseif ($totalNilai >= 80.01) {
            $akreditasi = 'A-';
        } elseif ($totalNilai >= 75.01) {
            $akreditasi = 'B+';
        } elseif ($totalNilai >= 65.01) {
            $akreditasi = 'B';
        } elseif ($totalNilai >= 60.00) {
            $akreditasi = 'C';
        } elseif ($totalNilai >= 45.00) {
            $akreditasi = 'D';
        } else {
            $akreditasi = 'E';
        }

        Nilai::updateOrCreate(
            ['user_id' => $request->user_id, 'mata_kuliah' => $request->mata_kuliah],
            [
                'nilai_presensi' => $nilaiPresensi,
                'nilai_keaktifan' => $nilaiKeaktifan,
                'nilai_tugas' => $nilaiTugas,
                'nilai_uts' => $nilaiUTS,
                'nilai_uas' => $nilaiUAS,
                'total_nilai' => $totalNilai,
                'nilai' => $totalNilai,
                'akreditasi' => $akreditasi,
                'grade' => $akreditasi,
            ]
        );

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function updateNilai(Request $request, $id)
    {
        $this->checkAdmin();
        $nilaiObj = Nilai::findOrFail($id);

        $request->validate([
            'nilai_presensi' => 'nullable|numeric|min:0|max:100',
            'nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai_uts' => 'nullable|numeric|min:0|max:100',
            'nilai_uas' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilaiPresensi = $request->has('nilai_presensi') ? $request->nilai_presensi : $nilaiObj->nilai_presensi;
        $nilaiTugas = $request->has('nilai_tugas') ? $request->nilai_tugas : $nilaiObj->nilai_tugas;
        $nilaiKeaktifan = $nilaiTugas; // Keaktifan menyatu dengan tugas
        $nilaiUTS = $request->has('nilai_uts') ? $request->nilai_uts : $nilaiObj->nilai_uts;
        $nilaiUAS = $request->has('nilai_uas') ? $request->nilai_uas : $nilaiObj->nilai_uas;

        $totalNilai = ($nilaiPresensi * 0.20) + ($nilaiTugas * 0.20) + ($nilaiUTS * 0.25) + ($nilaiUAS * 0.35);

        if ($totalNilai >= 85.01) {
            $akreditasi = 'A';
        } elseif ($totalNilai >= 80.01) {
            $akreditasi = 'A-';
        } elseif ($totalNilai >= 75.01) {
            $akreditasi = 'B+';
        } elseif ($totalNilai >= 65.01) {
            $akreditasi = 'B';
        } elseif ($totalNilai >= 60.00) {
            $akreditasi = 'C';
        } elseif ($totalNilai >= 45.00) {
            $akreditasi = 'D';
        } else {
            $akreditasi = 'E';
        }

        $nilaiObj->update([
            'nilai_presensi' => $nilaiPresensi,
            'nilai_keaktifan' => $nilaiKeaktifan,
            'nilai_tugas' => $nilaiTugas,
            'nilai_uts' => $nilaiUTS,
            'nilai_uas' => $nilaiUAS,
            'total_nilai' => $totalNilai,
            'nilai' => $totalNilai,
            'akreditasi' => $akreditasi,
            'grade' => $akreditasi,
        ]);

        return back()->with('success', 'Nilai berhasil diperbarui!');
    }

    public function deleteNilai($id)
    {
        $this->checkAdmin();
        Nilai::destroy($id);
        return back()->with('success', 'Nilai berhasil dihapus!');
    }

    private function calculateGrade($skor)
    {
        if ($skor >= 85) return 'A';
        if ($skor >= 75) return 'B';
        if ($skor >= 60) return 'C';
        if ($skor >= 50) return 'D';
        return 'E';
    }

    // --- Materi CRUD ---
    public function storeMateri(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'judul' => 'required|string|max:255',
            'mata_kuliah' => 'required|string',
            'pertemuan' => 'required|integer|min:1|max:16',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|max:10240',
        ]);

        $filePath = $request->file('file')->store('materi', 'public');

        Materi::create([
            'judul' => $request->judul,
            'mata_kuliah' => $request->mata_kuliah,
            'pertemuan' => $request->pertemuan,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Materi berhasil ditambahkan!');
    }

    public function updateMateri(Request $request, $id)
    {
        $this->checkAdmin();
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'mata_kuliah' => 'required|string',
            'pertemuan' => 'required|integer|min:1|max:16',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $materi->judul = $request->judul;
        $materi->mata_kuliah = $request->mata_kuliah;
        $materi->pertemuan = $request->pertemuan;
        $materi->deskripsi = $request->deskripsi;

        if ($request->hasFile('file')) {
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $materi->file_path = $request->file('file')->store('materi', 'public');
        }

        $materi->save();

        return back()->with('success', 'Materi berhasil diperbarui!');
    }

    public function deleteMateri($id)
    {
        $this->checkAdmin();
        $materi = Materi::findOrFail($id);
        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }
        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus!');
    }

    // ==========================================
    // MANAJEMEN PENGUMUMAN
    // ==========================================
    public function pengumuman()
    {
        $this->checkAdmin();
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('admin.pengumuman', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240', // 10MB limit
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcements', 'public');
        }

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Pengumuman baru berhasil diterbitkan!');
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $this->checkAdmin();
        $ann = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $ann->title = $request->title;
        $ann->content = $request->content;

        if ($request->hasFile('file')) {
            if ($ann->file_path && Storage::disk('public')->exists($ann->file_path)) {
                Storage::disk('public')->delete($ann->file_path);
            }
            $ann->file_path = $request->file('file')->store('announcements', 'public');
        }

        $ann->save();

        return back()->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function deleteAnnouncement($id)
    {
        $this->checkAdmin();
        $ann = Announcement::findOrFail($id);
        if ($ann->file_path && Storage::disk('public')->exists($ann->file_path)) {
            Storage::disk('public')->delete($ann->file_path);
        }
        $ann->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }

    public function downloadAnnouncement($id)
    {
        $ann = Announcement::findOrFail($id);
        if (!$ann->file_path || !Storage::disk('public')->exists($ann->file_path)) {
            abort(404, 'File pengumuman tidak ditemukan.');
        }
        return response()->download(storage_path('app/public/' . $ann->file_path));
    }

    // Halaman: Daftar Mahasiswa
    public function mahasiswa()
    {
        $this->checkAdmin();
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name', 'asc')->get();
        
        foreach ($mahasiswa as $m) {
            $m->nilai_details = Nilai::where('user_id', $m->id)->get();
        }

        return view('admin.mahasiswa', compact('mahasiswa'));
    }

    // Aksi: Impor Nilai dari Excel JSON
    public function importNilai(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'mata_kuliah' => 'required|string',
            'grades' => 'required|array',
        ]);

        $mataKuliah = $request->mata_kuliah;
        $grades = $request->grades;

        $successCount = 0;
        $errors = [];

        foreach ($grades as $index => $row) {
            $email = $row['email'] ?? $row['Email'] ?? null;
            if (!$email) {
                $errors[] = "Baris " . ($index + 1) . ": Email tidak ditemukan.";
                continue;
            }

            $user = User::where('email', $email)->where('role', 'mahasiswa')->first();
            if (!$user) {
                $errors[] = "Baris " . ($index + 1) . ": Mahasiswa dengan email {$email} tidak ditemukan.";
                continue;
            }

            $presensi = isset($row['presensi']) ? $row['presensi'] : (isset($row['Presensi']) ? $row['Presensi'] : null);
            $tugas = isset($row['tugas']) ? $row['tugas'] : (isset($row['Tugas']) ? $row['Tugas'] : null);
            $uts = isset($row['uts']) ? $row['uts'] : (isset($row['UTS']) ? $row['UTS'] : null);
            $uas = isset($row['uas']) ? $row['uas'] : (isset($row['UAS']) ? $row['UAS'] : null);

            Nilai::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'mata_kuliah' => $mataKuliah,
                ],
                [
                    'nilai_presensi' => $presensi !== null ? floatval($presensi) : null,
                    'nilai_tugas' => $tugas !== null ? floatval($tugas) : null,
                    'nilai_keaktifan' => $tugas !== null ? floatval($tugas) : null,
                    'nilai_uts' => $uts !== null ? floatval($uts) : null,
                    'nilai_uas' => $uas !== null ? floatval($uas) : null,
                ]
            );

            if ($tugas !== null) {
                NilaiPertemuan::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'mata_kuliah' => $mataKuliah,
                        'pertemuan' => 1,
                    ],
                    [
                        'nilai_tugas' => floatval($tugas),
                        'nilai_keaktifan' => floatval($tugas),
                    ]
                );
            }

            $this->recalculateGradesLocal($user->id, $mataKuliah);
            $successCount++;
        }

        if (count($errors) > 0) {
            return back()->with('success', "Berhasil mengimpor {$successCount} data nilai.")
                ->withErrors($errors);
        }

        return back()->with('success', "Berhasil mengimpor {$successCount} data nilai mahasiswa!");
    }

    // Halaman: Jurnal & RPS
    public function jurnalRps()
    {
        $this->checkAdmin();
        $mataKuliah = MataKuliah::all();
        $rpsList = \App\Models\Rps::all();
        $jurnalList = \App\Models\JurnalKuliah::with('dosen')->get();

        return view('admin.jurnal', compact('mataKuliah', 'rpsList', 'jurnalList'));
    }

    // Aksi: Impor RPS
    public function importRps(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'mata_kuliah' => 'required|string',
            'rps_data' => 'required|array',
        ]);

        $mataKuliah = $request->mata_kuliah;
        $rpsData = $request->rps_data;

        \App\Models\Rps::where('mata_kuliah', $mataKuliah)->delete();

        $successCount = 0;
        foreach ($rpsData as $row) {
            $pertemuan = intval($row['pertemuan'] ?? $row['Pertemuan'] ?? 0);
            $topik = $row['topik'] ?? $row['Topik'] ?? '';
            $aktivitas = $row['aktivitas'] ?? $row['Aktivitas'] ?? '';

            if ($pertemuan >= 1 && $pertemuan <= 16 && !empty($topik)) {
                \App\Models\Rps::create([
                    'mata_kuliah' => $mataKuliah,
                    'pertemuan' => $pertemuan,
                    'topik' => $topik,
                    'aktivitas' => $aktivitas,
                ]);
                $successCount++;
            }
        }

        return back()->with('success', "Berhasil mengimpor {$successCount} pertemuan RPS untuk mata kuliah {$mataKuliah}!");
    }

    // Aksi: Simpan Jurnal
    public function storeJurnal(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'mata_kuliah' => 'required|string',
            'pertemuan' => 'required|integer|min:1|max:16',
            'tanggal' => 'required|date',
            'materi_realisasi' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:terlaksana,batal,tunda',
        ]);

        \App\Models\JurnalKuliah::updateOrCreate(
            [
                'mata_kuliah' => $request->mata_kuliah,
                'pertemuan' => $request->pertemuan,
            ],
            [
                'dosen_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'materi_realisasi' => $request->materi_realisasi,
                'catatan' => $request->catatan,
                'status' => $request->status,
            ]
        );

        return back()->with('success', 'Jurnal pertemuan ' . $request->pertemuan . ' berhasil disimpan!');
    }

    // Helper: Hitung Nilai dari Admin
    private function recalculateGradesLocal($userId, $courseName)
    {
        $presensi = \App\Models\Presensi::where('user_id', $userId)
            ->where('mata_kuliah', $courseName)
            ->get();
            
        $hadir = $presensi->where('status', 'H')->count();
        $izin = $presensi->where('status', 'I')->count();
        $sakit = $presensi->where('status', 'S')->count();
        
        $nilaiPresensi = min(100, ($hadir + $izin + $sakit) * 6.25);
        
        $nilaiObj = Nilai::where('user_id', $userId)->where('mata_kuliah', $courseName)->first();
        
        $nilaiTugas = $nilaiObj ? $nilaiObj->nilai_tugas : 0;
        $nilaiUTS = $nilaiObj ? $nilaiObj->nilai_uts : 0;
        $nilaiUAS = $nilaiObj ? $nilaiObj->nilai_uas : 0;
        
        $totalNilai = ($nilaiPresensi * 0.20) + ($nilaiTugas * 0.20) + (($nilaiUTS ?? 0) * 0.25) + (($nilaiUAS ?? 0) * 0.35);
        
        if ($totalNilai >= 85.01) {
            $akreditasi = 'A';
        } elseif ($totalNilai >= 80.01) {
            $akreditasi = 'A-';
        } elseif ($totalNilai >= 75.01) {
            $akreditasi = 'B+';
        } elseif ($totalNilai >= 65.01) {
            $akreditasi = 'B';
        } elseif ($totalNilai >= 60.00) {
            $akreditasi = 'C';
        } elseif ($totalNilai >= 45.00) {
            $akreditasi = 'D';
        } else {
            $akreditasi = 'E';
        }

        if ($nilaiObj) {
            $nilaiObj->update([
                'nilai_presensi' => $nilaiPresensi,
                'nilai_keaktifan' => $nilaiTugas,
                'total_nilai' => $totalNilai,
                'nilai' => $totalNilai,
                'akreditasi' => $akreditasi,
                'grade' => $akreditasi,
            ]);
        }
    }
}

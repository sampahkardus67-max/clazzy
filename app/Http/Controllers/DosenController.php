<?php
namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Tugas;
use App\Models\TugasDosen;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Materi;
use App\Models\Presensi;
use App\Models\NilaiPertemuan;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Halaman: Mata Kuliah Diajar
    public function mataKuliah()
    {
        $dosenName = auth()->user()->name;
        $mataKuliah = MataKuliah::where('dosen', $dosenName)->get();
        
        // Buat jadwal dummy statis agar terlihat premium & informatif
        $jadwalDummy = [
            'IF101' => ['hari' => 'Senin', 'jam' => '08:00 - 10:30', 'ruang' => 'Lab Komputer 3'],
            'IF201' => ['hari' => 'Rabu', 'jam' => '13:00 - 15:30', 'ruang' => 'Lab Web & Desain'],
            'SI101' => ['hari' => 'Selasa', 'jam' => '10:00 - 12:30', 'ruang' => 'Ruang Teori 102'],
            'IF301' => ['hari' => 'Kamis', 'jam' => '08:00 - 10:30', 'ruang' => 'Lab Jaringan'],
        ];

        foreach ($mataKuliah as $mk) {
            $mk->jadwal = $jadwalDummy[$mk->kode] ?? ['hari' => 'Jumat', 'jam' => '13:00 - 15:30', 'ruang' => 'Ruang Teori A'];
        }

        return view('dosen.mata-kuliah', compact('mataKuliah'));
    }

    // Halaman: Tugas Baru (kelola tugas dosen & submission mahasiswa)
    public function tugas()
    {
        $dosenName = auth()->user()->name;
        // Ambil nama mata kuliah yang diampu dosen
        $myCourses = MataKuliah::where('dosen', $dosenName)->pluck('nama')->toArray();
        
        // Ambil tugas yang pernah diunggah dosen
        $tugasDosen = TugasDosen::whereIn('mata_kuliah', $myCourses)
            ->orderBy('deadline', 'asc')
            ->get();
            
        // Ambil kiriman tugas mahasiswa
        $tugasMahasiswa = Tugas::with('user')->orderBy('created_at', 'desc')->get();

        return view('dosen.tugas', compact('tugasDosen', 'tugasMahasiswa', 'myCourses'));
    }

    // Aksi: Kirim / Upload Tugas Baru untuk Mahasiswa
    public function storeTugas(Request $request)
    {
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

        return back()->with('success', 'Tugas baru berhasil diterbitkan untuk mahasiswa!');
    }

    // Halaman: Input Nilai & Presensi
    public function nilai()
    {
        $dosenName = auth()->user()->name;
        $myCourses = MataKuliah::where('dosen', $dosenName)->get();
        $myCoursesNames = $myCourses->pluck('nama')->toArray();
        
        // Ambil mahasiswa untuk dropdown/tabel
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        
        // Ambil nilai yang sudah diinputkan dosen
        $nilaiList = Nilai::whereIn('mata_kuliah', $myCoursesNames)
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Ambil riwayat presensi & nilai mingguan
        $presensiList = Presensi::whereIn('mata_kuliah', $myCoursesNames)->get();
        $nilaiPertemuanList = NilaiPertemuan::whereIn('mata_kuliah', $myCoursesNames)->get();

        return view('dosen.nilai', compact('myCourses', 'mahasiswa', 'nilaiList', 'presensiList', 'nilaiPertemuanList'));
    }

    // Aksi: Simpan Nilai UTS / UAS
    public function storeNilai(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mata_kuliah' => 'required|string',
            'tipe' => 'required|in:uts,uas',
            'skor' => 'required|numeric|min:0|max:100',
        ]);

        $column = $request->tipe === 'uts' ? 'nilai_uts' : 'nilai_uas';

        Nilai::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'mata_kuliah' => $request->mata_kuliah,
            ],
            [
                $column => $request->skor,
            ]
        );

        $this->recalculateGrades($request->user_id, $request->mata_kuliah);

        return back()->with('success', 'Nilai ' . strtoupper($request->tipe) . ' berhasil disimpan!');
    }

    // Aksi: Simpan Presensi Mahasiswa Bulk
    public function storePresensi(Request $request)
    {
        $request->validate([
            'mata_kuliah' => 'required|string',
            'pertemuan' => 'required|integer|min:1|max:16',
            'statuses' => 'required|array',
        ]);

        foreach ($request->statuses as $userId => $status) {
            if (in_array($status, ['H', 'I', 'S', 'A'])) {
                Presensi::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'mata_kuliah' => $request->mata_kuliah,
                        'pertemuan' => $request->pertemuan,
                    ],
                    [
                        'status' => $status,
                    ]
                );

                $this->recalculateGrades($userId, $request->mata_kuliah);
            }
        }

        return back()->with('success', 'Presensi berhasil disimpan!');
    }

    // Aksi: Simpan Nilai Tugas / Keaktifan Pertemuan
    public function storeNilaiPertemuan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mata_kuliah' => 'required|string',
            'pertemuan' => 'required|integer|min:1|max:16',
            'tipe' => 'required|in:keaktifan,tugas',
            'skor' => 'required|numeric|min:0|max:100',
        ]);

        // Menyimpan nilai tugas & keaktifan sebagai satu kesatuan
        NilaiPertemuan::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'mata_kuliah' => $request->mata_kuliah,
                'pertemuan' => $request->pertemuan,
            ],
            [
                'nilai_tugas' => $request->skor,
                'nilai_keaktifan' => $request->skor,
            ]
        );

        $this->recalculateGrades($request->user_id, $request->mata_kuliah);

        return back()->with('success', 'Nilai Tugas & Keaktifan Pertemuan ' . $request->pertemuan . ' berhasil disimpan!');
    }

    // Fungsi Pembantu: Hitung Total Nilai Akhir & Akreditasi
    private function recalculateGrades($userId, $courseName)
    {
        // 1. Hitung Nilai Presensi
        $presensi = Presensi::where('user_id', $userId)
            ->where('mata_kuliah', $courseName)
            ->get();
            
        $hadir = $presensi->where('status', 'H')->count();
        $izin = $presensi->where('status', 'I')->count();
        $sakit = $presensi->where('status', 'S')->count();
        
        // Nilai Presensi = (H + I + S) * 6.25 (maksimal 100)
        $nilaiPresensi = min(100, ($hadir + $izin + $sakit) * 6.25);
        
        // 2. Hitung Nilai Rata-rata Tugas (Sekaligus Keaktifan)
        $scores = NilaiPertemuan::where('user_id', $userId)
            ->where('mata_kuliah', $courseName)
            ->get();
            
        $nilaiTugas = $scores->whereNotNull('nilai_tugas')->avg('nilai_tugas') ?? 0;
        $nilaiKeaktifan = $nilaiTugas; // Keaktifan menyatu dengan tugas
        
        // 4. Ambil UTS & UAS
        $nilaiObj = Nilai::where('user_id', $userId)->where('mata_kuliah', $courseName)->first();
        $nilaiUTS = $nilaiObj ? $nilaiObj->nilai_uts : 0;
        $nilaiUAS = $nilaiObj ? $nilaiObj->nilai_uas : 0;
        
        // 5. Hitung Total Nilai Akhir
        // Formula: Presensi * 20% + Tugas * 20% + UTS * 25% + UAS * 35%
        $totalNilai = ($nilaiPresensi * 0.20) + ($nilaiTugas * 0.20) + (($nilaiUTS ?? 0) * 0.25) + (($nilaiUAS ?? 0) * 0.35);
        
        // 6. Hitung Akreditasi / Grade
        // >= 85.01 -> A, >= 80.01 -> A-, >= 75.01 -> B+, >= 65.01 -> B, >= 60.00 -> C, >= 45.00 -> D, else -> E
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
        
        // 7. Simpan
        Nilai::updateOrCreate(
            [
                'user_id' => $userId,
                'mata_kuliah' => $courseName,
            ],
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
    }

    // Halaman: Upload Materi
    public function materi()
    {
        $dosenName = auth()->user()->name;
        $myCourses = MataKuliah::where('dosen', $dosenName)->get();
        $myCoursesNames = $myCourses->pluck('nama')->toArray();
        $materiList = Materi::whereIn('mata_kuliah', $myCoursesNames)->orderBy('pertemuan', 'asc')->get();
        return view('dosen.materi', compact('materiList', 'myCourses'));
    }

    // Aksi: Simpan Materi
    public function storeMateri(Request $request)
    {
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

        return back()->with('success', 'Materi baru berhasil diunggah!');
    }

    // Aksi: Hapus Materi
    public function destroyMateri($id)
    {
        $materi = Materi::findOrFail($id);
        if (\Storage::disk('public')->exists($materi->file_path)) {
            \Storage::disk('public')->delete($materi->file_path);
        }
        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus!');
    }

    // Halaman: Daftar Mahasiswa
    public function mahasiswa(Request $request)
    {
        $dosenName = auth()->user()->name;
        $myCourses = MataKuliah::where('dosen', $dosenName)->get();
        $myCoursesNames = $myCourses->pluck('nama')->toArray();

        $selectedCourse = $request->get('mata_kuliah');

        $mahasiswaQuery = User::where('role', 'mahasiswa');

        if ($selectedCourse && in_array($selectedCourse, $myCoursesNames)) {
            $userIds = Nilai::where('mata_kuliah', $selectedCourse)->pluck('user_id')->toArray();
            $mahasiswa = $mahasiswaQuery->whereIn('id', $userIds)->get();
        } else {
            $mahasiswa = $mahasiswaQuery->get();
        }

        foreach ($mahasiswa as $m) {
            $m->nilai_details = Nilai::where('user_id', $m->id)
                ->whereIn('mata_kuliah', $myCoursesNames)
                ->get();
        }

        return view('dosen.mahasiswa', compact('mahasiswa', 'myCourses', 'selectedCourse'));
    }

    // Aksi: Impor Nilai dari Excel JSON
    public function importNilai(Request $request)
    {
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

            $this->recalculateGrades($user->id, $mataKuliah);
            $successCount++;
        }

        if (count($errors) > 0) {
            return back()->with('success', "Berhasil mengimpor {$successCount} data nilai.")
                ->withErrors($errors);
        }

        return back()->with('success', "Berhasil mengimpor {$successCount} data nilai mahasiswa!");
    }

    // Halaman: Jurnal Kuliah & RPS
    public function jurnalRps()
    {
        $dosenName = auth()->user()->name;
        $myCourses = MataKuliah::where('dosen', $dosenName)->get();
        $myCoursesNames = $myCourses->pluck('nama')->toArray();

        $rpsList = \App\Models\Rps::whereIn('mata_kuliah', $myCoursesNames)->get();
        $jurnalList = \App\Models\JurnalKuliah::whereIn('mata_kuliah', $myCoursesNames)->get();

        return view('dosen.jurnal', compact('myCourses', 'rpsList', 'jurnalList'));
    }

    // Aksi: Impor RPS
    public function importRps(Request $request)
    {
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

    // Aksi: Simpan Jurnal Kuliah
    public function storeJurnal(Request $request)
    {
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
}

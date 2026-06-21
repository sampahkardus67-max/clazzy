<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas - Admin Clazzy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; color: #333; }
        .navbar { background: #e0e0e0; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { display: flex; align-items: center; gap: 0.5rem; font-size: 1.8rem; font-weight: bold; text-decoration: none; color: #333; }
        .logo-icon { background: linear-gradient(135deg, #0891b2, #06b6d4); color: white; width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .nav-right { display: flex; align-items: center; gap: 1rem; }
        .btn { padding: 0.6rem 1.5rem; border: 2px solid #00bcd4; border-radius: 8px; background: white; color: #00bcd4; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; }
        .btn:hover { background: #00bcd4; color: white; }
        .btn-logout { background: #d32f2f; color: white; border-color: #d32f2f; }
        .btn-logout:hover { background: #c62828; border-color: #c62828; }
        
        .btn-action { padding: 0.4rem 0.8rem; font-size: 0.85rem; }
        .btn-edit { background: #e0f2fe; color: #0369a1; border-color: #0369a1; }
        .btn-edit:hover { background: #0369a1; color: white; }
        .btn-danger { background: #fee2e2; color: #991b1b; border-color: #991b1b; }
        .btn-danger:hover { background: #991b1b; color: white; }
        .btn-add { background: #9333ea; color: white; border-color: #9333ea; }
        .btn-add:hover { background: #7e22ce; border-color: #7e22ce; }
        .btn-download { background: #0891b2; color: white; border-color: #0891b2; }
        .btn-download:hover { background: #0e7490; border-color: #0e7490; }

        .tabs { background: white; padding: 0 2rem; display: flex; gap: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .tab:hover { color: #9333ea; }
        .tab.active { color: #9333ea; border-bottom-color: #9333ea; }
        
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: #9333ea; }

        /* Sub tabs */
        .sub-tabs { display: flex; gap: 0; margin-bottom: 1.5rem; background: white; border-radius: 12px; padding: 0.4rem; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: fit-content; }
        .sub-tab { padding: 0.6rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; border: none; background: transparent; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; }
        .sub-tab.active { background: #9333ea; color: white; }
        .sub-tab:hover:not(.active) { background: #f3e8ff; color: #9333ea; }
        
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* Form Layout */
        .flex-container { display: flex; gap: 2rem; align-items: flex-start; }
        .form-section { flex: 1.2; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; }
        .list-section { flex: 2; }
        
        h3 { margin-bottom: 1.5rem; font-size: 1.2rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; font-size: 0.9rem; }
        input[type="text"], input[type="number"], select, textarea, input[type="datetime-local"] { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
        input[type="text"]:focus, input[type="number"]:focus, select:focus, textarea:focus, input[type="datetime-local"]:focus { outline: none; border-color: #9333ea; }
        textarea { resize: vertical; min-height: 100px; }

        /* Table Styling */
        .card-table { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #0891b2, #06b6d4); color: white; }
        th { padding: 1rem 1.5rem; text-align: left; font-weight: 600; }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdfa; }

        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .badge-purple { background: #ede9fe; color: #7c3aed; }
        .badge-blue { background: #e0f2fe; color: #0369a1; }
        .badge-green { background: #dcfce7; color: #16a34a; }

        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #4caf50; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .empty { text-align: center; padding: 4rem; color: #999; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .empty i { font-size: 3rem; margin-bottom: 1rem; display: block; }
        
        @media (max-width: 992px) {
            .flex-container { flex-direction: column; }
            .form-section, .list-section { width: 100%; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">C</div>
            <span>Clazzy</span>
        </a>
        <div class="nav-right">
            <span><strong>{{ auth()->user()->name }}</strong> (Admin)</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </nav>

    <div class="tabs">
        <a href="{{ route('dashboard') }}" class="tab"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('admin.users') }}" class="tab"><i class="fas fa-users-cog"></i> Manajemen User</a>
        <a href="{{ route('admin.kelas') }}" class="tab active"><i class="fas fa-book-open"></i> Manajemen Kelas</a>
        <a href="{{ route('admin.jurnal-rps') }}" class="tab"><i class="fas fa-journal-whills"></i> Jurnal & RPS</a>
        <a href="{{ route('admin.mahasiswa') }}" class="tab"><i class="fas fa-user-friends"></i> Daftar Mahasiswa</a>
        <a href="{{ route('admin.pengumuman') }}" class="tab"><i class="fas fa-bullhorn"></i> Pengumuman</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-book-open"></i> Manajemen Data Akademik & Kelas</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        {{-- Sub Navigation Tabs --}}
        <div class="sub-tabs">
            <button class="sub-tab active" onclick="switchTab('matakuliah')"><i class="fas fa-scroll"></i> Mata Kuliah</button>
            <button class="sub-tab" onclick="switchTab('tugas')"><i class="fas fa-tasks"></i> Tugas Dosen</button>
            <button class="sub-tab" onclick="switchTab('submissions')"><i class="fas fa-inbox"></i> Tugas Mahasiswa</button>
            <button class="sub-tab" onclick="switchTab('nilai')"><i class="fas fa-star"></i> Nilai Mahasiswa</button>
            <button class="sub-tab" onclick="switchTab('materi')"><i class="fas fa-book-open"></i> Materi Kuliah</button>
        </div>

        <!-- ========================================== -->
        <!-- TAB: MATA KULIAH -->
        <!-- ========================================== -->
        <div id="panel-matakuliah" class="tab-panel active">
            <div class="flex-container">
                <div class="form-section">
                    <h3 id="mk-form-title"><i class="fas fa-plus-circle"></i> Tambah Mata Kuliah</h3>
                    <form id="mk-form" action="{{ route('admin.matakuliah.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="mk-kode">Kode Mata Kuliah</label>
                            <input type="text" name="kode" id="mk-kode" placeholder="Contoh: IF201" required>
                        </div>
                        <div class="form-group">
                            <label for="mk-nama">Nama Mata Kuliah</label>
                            <input type="text" name="nama" id="mk-nama" placeholder="Contoh: Pemrograman Web" required>
                        </div>
                        <div class="form-group">
                            <label for="mk-sks">Jumlah SKS</label>
                            <input type="number" name="sks" id="mk-sks" min="1" max="6" placeholder="Contoh: 3" required>
                        </div>
                        <div class="form-group">
                            <label for="mk-dosen">Dosen Pengampu</label>
                            <select name="dosen" id="mk-dosen" required>
                                <option value="" disabled selected>-- Pilih Dosen Pengampu --</option>
                                @foreach($dosen as $d)
                                    <option value="{{ $d->name }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="mk-submit-btn" class="btn btn-add" style="width: 100%; justify-content: center;">
                            <i class="fas fa-plus"></i> Simpan Mata Kuliah
                        </button>
                        <button type="button" id="mk-cancel-btn" class="btn" style="width: 100%; justify-content: center; margin-top: 0.5rem; display: none;" onclick="resetMkForm()">
                            Batal Edit
                        </button>
                    </form>
                </div>

                <div class="list-section">
                    <h3><i class="fas fa-list-ul"></i> Daftar Mata Kuliah</h3>
                    @if($mataKuliah->isEmpty())
                        <div class="empty"><i class="fas fa-folder-open"></i><p>Belum ada mata kuliah.</p></div>
                    @else
                        <div class="card-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mataKuliah as $mk)
                                    <tr>
                                        <td><span class="badge badge-purple">{{ $mk->kode }}</span></td>
                                        <td><strong>{{ $mk->nama }}</strong></td>
                                        <td>{{ $mk->sks }} SKS</td>
                                        <td><span style="font-size:0.9rem;">{{ $mk->dosen }}</span></td>
                                        <td>
                                            <div style="display:flex; gap:0.5rem;">
                                                <button type="button" class="btn btn-action btn-edit" onclick="editMk({{ json_encode($mk) }})">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.matakuliah.delete', $mk->id) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-action btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB: TUGAS DOSEN -->
        <!-- ========================================== -->
        <div id="panel-tugas" class="tab-panel">
            <div class="flex-container">
                <div class="form-section">
                    <h3 id="tugas-form-title"><i class="fas fa-plus-circle"></i> Tambah Tugas Dosen</h3>
                    <form id="tugas-form" action="{{ route('admin.tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tugas-mk">Mata Kuliah</label>
                            <select name="mata_kuliah" id="tugas-mk" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($mataKuliah as $mk)
                                    <option value="{{ $mk->nama }}">{{ $mk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tugas-judul">Judul Tugas</label>
                            <input type="text" name="judul" id="tugas-judul" placeholder="Contoh: Tugas 1: Algoritma Sorting" required>
                        </div>
                        <div class="form-group">
                            <label for="tugas-penjelasan">Petunjuk / Penjelasan</label>
                            <textarea name="penjelasan" id="tugas-penjelasan" placeholder="Tulis instruksi tugas di sini..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tugas-deadline">Deadline</label>
                            <input type="datetime-local" name="deadline" id="tugas-deadline" required>
                        </div>
                        <div class="form-group">
                            <label for="tugas-file">Lampiran File (Opsional)</label>
                            <input type="file" name="file" id="tugas-file">
                        </div>
                        <button type="submit" id="tugas-submit-btn" class="btn btn-add" style="width: 100%; justify-content: center;">
                            <i class="fas fa-plus"></i> Simpan Tugas
                        </button>
                        <button type="button" id="tugas-cancel-btn" class="btn" style="width: 100%; justify-content: center; margin-top: 0.5rem; display: none;" onclick="resetTugasForm()">
                            Batal Edit
                        </button>
                    </form>
                </div>

                <div class="list-section">
                    <h3><i class="fas fa-list-ul"></i> Daftar Tugas yang Diterbitkan</h3>
                    @if($tugasDosen->isEmpty())
                        <div class="empty"><i class="fas fa-folder-open"></i><p>Belum ada tugas dosen.</p></div>
                    @else
                        <div class="card-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mata Kuliah / Judul</th>
                                        <th>Deadline</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tugasDosen as $td)
                                    <tr>
                                        <td>
                                            <span class="badge badge-blue" style="margin-bottom:0.3rem;">{{ $td->mata_kuliah }}</span><br>
                                            <strong>{{ $td->judul }}</strong>
                                        </td>
                                        <td><span style="font-size:0.9rem;">{{ $td->deadline->format('d M Y, H:i') }}</span></td>
                                        <td>
                                            <div style="display:flex; gap:0.5rem; flex-direction:column;">
                                                <button type="button" class="btn btn-action btn-edit" onclick="editTugas({{ json_encode($td) }})">Edit</button>
                                                <form action="{{ route('admin.tugas.delete', $td->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-action btn-danger" style="width:100%;">Hapus</button>
                                                </form>
                                                @if($td->file_path)
                                                    <a href="{{ asset('storage/' . $td->file_path) }}" class="btn btn-action btn-download" style="text-align:center;" download>File</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB: TUGAS MAHASISWA (SUBMISSIONS) -->
        <!-- ========================================== -->
        <div id="panel-submissions" class="tab-panel">
            <h3><i class="fas fa-inbox"></i> Kiriman Jawaban Mahasiswa</h3>
            @if($tugasMahasiswa->isEmpty())
                <div class="empty"><i class="fas fa-folder-open"></i><p>Belum ada tugas dikirim oleh mahasiswa.</p></div>
            @else
                <div class="card-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mahasiswa</th>
                                <th>File Jawaban</th>
                                <th>Dikirim Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tugasMahasiswa as $i => $tm)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $tm->user->name ?? 'Mahasiswa' }}</strong><br>
                                    <span style="font-size:0.85rem; color:#6b7280;">{{ $tm->user->email ?? '' }}</span>
                                </td>
                                <td><i class="far fa-file" style="margin-right:0.4rem;"></i>{{ $tm->nama }}</td>
                                <td>{{ $tm->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <a href="{{ route('tugas.download', $tm->id) }}" class="btn btn-action btn-download"><i class="fas fa-download"></i> Unduh</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- TAB: NILAI MAHASISWA -->
        <!-- ========================================== -->
        <div id="panel-nilai" class="tab-panel">
            <div class="flex-container">
                <div class="form-section">
                    <h3 id="nilai-form-title"><i class="fas fa-star"></i> Kelola Nilai</h3>
                    <form id="nilai-form" action="{{ route('admin.nilai.store') }}" method="POST">
                        @csrf
                        <div class="form-group" id="nilai-user-group">
                            <label for="nilai-user">Mahasiswa</label>
                            <select name="user_id" id="nilai-user" required>
                                <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="nilai-mk-group">
                            <label for="nilai-mk">Mata Kuliah</label>
                            <select name="mata_kuliah" id="nilai-mk" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($mataKuliah as $mk)
                                    <option value="{{ $mk->nama }}">{{ $mk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nilai-presensi">Nilai Presensi (0 - 100)</label>
                            <input type="number" name="nilai_presensi" id="nilai-presensi" min="0" max="100" placeholder="Skor Presensi" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="nilai-tugas">Nilai Tugas & Keaktifan (0 - 100)</label>
                            <input type="number" name="nilai_tugas" id="nilai-tugas" min="0" max="100" placeholder="Skor Tugas & Keaktifan" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="nilai-uts">Nilai UTS (0 - 100)</label>
                            <input type="number" name="nilai_uts" id="nilai-uts" min="0" max="100" placeholder="Skor UTS" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="nilai-uas">Nilai UAS (0 - 100)</label>
                            <input type="number" name="nilai_uas" id="nilai-uas" min="0" max="100" placeholder="Skor UAS" step="0.01">
                        </div>
                        <button type="submit" id="nilai-submit-btn" class="btn btn-add" style="width: 100%; justify-content: center;">
                            <i class="fas fa-save"></i> Simpan Nilai
                        </button>
                        <button type="button" id="nilai-cancel-btn" class="btn" style="width: 100%; justify-content: center; margin-top: 0.5rem; display: none;" onclick="resetNilaiForm()">
                            Batal Edit
                        </button>
                    </form>
                </div>

                <div class="list-section">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:1rem;">
                        <h3><i class="fas fa-clipboard-list"></i> Nilai Mahasiswa Terdaftar</h3>
                        <div>
                            <button type="button" class="btn btn-add btn-excel btn-action" style="background: #22c55e; border-color: #22c55e; color: white;" onclick="openExcelModal()">
                                <i class="fas fa-file-excel"></i> Impor Nilai Excel
                            </button>
                        </div>
                    </div>
                    @if($nilaiList->isEmpty())
                        <div class="empty"><i class="fas fa-folder-open"></i><p>Belum ada data nilai.</p></div>
                    @else
                        <div class="card-table" style="overflow-x: auto;">
                            <table style="min-width: 800px;">
                                <thead>
                                    <tr>
                                        <th>Mahasiswa</th>
                                        <th>Mata Kuliah</th>
                                        <th style="text-align: center;">Presensi (20%)</th>
                                        <th style="text-align: center;">Tugas & Keaktifan (20%)</th>
                                        <th style="text-align: center;">UTS (25%)</th>
                                        <th style="text-align: center;">UAS (35%)</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">Grade</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiList as $n)
                                    <tr>
                                        <td><strong>{{ $n->user->name ?? 'Mahasiswa' }}</strong></td>
                                        <td>{{ $n->mata_kuliah }}</td>
                                        <td style="text-align: center;">{{ $n->nilai_presensi !== null ? number_format($n->nilai_presensi, 1) : '-' }}</td>
                                        <td style="text-align: center;">{{ $n->nilai_tugas !== null ? number_format($n->nilai_tugas, 1) : '-' }}</td>
                                        <td style="text-align: center;">{{ $n->nilai_uts !== null ? number_format($n->nilai_uts, 1) : '-' }}</td>
                                        <td style="text-align: center;">{{ $n->nilai_uas !== null ? number_format($n->nilai_uas, 1) : '-' }}</td>
                                        <td style="text-align: center;"><strong>{{ $n->total_nilai !== null ? number_format($n->total_nilai, 2) : '-' }}</strong></td>
                                        <td style="text-align: center;">
                                            @if($n->akreditasi)
                                                <span class="badge badge-purple">{{ $n->akreditasi }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div style="display:flex; gap:0.5rem;">
                                                <button type="button" class="btn btn-action btn-edit" onclick="editNilai({{ json_encode($n) }})">Edit</button>
                                                <form action="{{ route('admin.nilai.delete', $n->id) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-action btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB: MATERI KULIAH -->
        <!-- ========================================== -->
        <div id="panel-materi" class="tab-panel">
            <div class="flex-container">
                <div class="form-section">
                    <h3 id="materi-form-title"><i class="fas fa-plus-circle"></i> Tambah / Upload Materi</h3>
                    <form id="materi-form" action="{{ route('admin.materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="materi-mk">Mata Kuliah</label>
                            <select name="mata_kuliah" id="materi-mk" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($mataKuliah as $mk)
                                    <option value="{{ $mk->nama }}">{{ $mk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="materi-pertemuan">Pertemuan Ke-</label>
                            <select name="pertemuan" id="materi-pertemuan" required>
                                @for($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}">Pertemuan {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="materi-judul">Judul Materi</label>
                            <input type="text" name="judul" id="materi-judul" placeholder="Contoh: Pengenalan OOP" required>
                        </div>
                        <div class="form-group">
                            <label for="materi-deskripsi">Deskripsi Singkat</label>
                            <textarea name="deskripsi" id="materi-deskripsi" placeholder="Tulis deskripsi materi kuliah..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="materi-file">File Dokumen Materi</label>
                            <input type="file" name="file" id="materi-file" required>
                        </div>
                        <button type="submit" id="materi-submit-btn" class="btn btn-add" style="width: 100%; justify-content: center;">
                            <i class="fas fa-plus"></i> Simpan Materi
                        </button>
                        <button type="button" id="materi-cancel-btn" class="btn" style="width: 100%; justify-content: center; margin-top: 0.5rem; display: none;" onclick="resetMateriForm()">
                            Batal Edit
                        </button>
                    </form>
                </div>

                <div class="list-section">
                    <h3><i class="fas fa-list-ul"></i> Daftar Materi Terunggah</h3>
                    @if($materiList->isEmpty())
                        <div class="empty"><i class="fas fa-folder-open"></i><p>Belum ada berkas materi kuliah.</p></div>
                    @else
                        <div class="card-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Pertemuan</th>
                                        <th>Mata Kuliah / Judul</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materiList as $mat)
                                    <tr>
                                        <td><span class="badge badge-purple">Pertemuan {{ $mat->pertemuan }}</span></td>
                                        <td>
                                            <span class="badge badge-blue" style="margin-bottom:0.3rem;">{{ $mat->mata_kuliah }}</span><br>
                                            <strong>{{ $mat->judul }}</strong>
                                        </td>
                                        <td>
                                            <div style="display:flex; gap:0.5rem; flex-direction:column;">
                                                <button type="button" class="btn btn-action btn-edit" onclick="editMateri({{ json_encode($mat) }})">Edit</button>
                                                <form action="{{ route('admin.materi.delete', $mat->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-action btn-danger" style="width:100%;">Hapus</button>
                                                </form>
                                                <a href="{{ asset('storage/' . $mat->file_path) }}" class="btn btn-action btn-download" style="text-align:center;" download>Unduh</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(name) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.sub-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('panel-' + name).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // --- MATA KULIAH JS ---
        function editMk(mk) {
            document.getElementById('mk-form-title').innerHTML = '<i class="fas fa-edit"></i> Edit Mata Kuliah';
            document.getElementById('mk-form').action = '/admin/matakuliah/update/' + mk.id;
            
            document.getElementById('mk-kode').value = mk.kode;
            document.getElementById('mk-nama').value = mk.nama;
            document.getElementById('mk-sks').value = mk.sks;
            document.getElementById('mk-dosen').value = mk.dosen;
            
            document.getElementById('mk-submit-btn').innerHTML = '<i class="fas fa-save"></i> Perbarui';
            document.getElementById('mk-submit-btn').className = 'btn btn-edit';
            document.getElementById('mk-cancel-btn').style.display = 'inline-flex';
        }

        function resetMkForm() {
            document.getElementById('mk-form-title').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Mata Kuliah';
            document.getElementById('mk-form').action = '{{ route("admin.matakuliah.store") }}';
            
            document.getElementById('mk-kode').value = '';
            document.getElementById('mk-nama').value = '';
            document.getElementById('mk-sks').value = '';
            document.getElementById('mk-dosen').value = '';
            
            document.getElementById('mk-submit-btn').innerHTML = '<i class="fas fa-plus"></i> Simpan Mata Kuliah';
            document.getElementById('mk-submit-btn').className = 'btn btn-add';
            document.getElementById('mk-cancel-btn').style.display = 'none';
        }

        // --- TUGAS JS ---
        function editTugas(td) {
            document.getElementById('tugas-form-title').innerHTML = '<i class="fas fa-edit"></i> Edit Tugas Dosen';
            document.getElementById('tugas-form').action = '/admin/tugas/update/' + td.id;
            
            document.getElementById('tugas-mk').value = td.mata_kuliah;
            document.getElementById('tugas-judul').value = td.judul;
            document.getElementById('tugas-penjelasan').value = td.penjelasan;
            
            // Format datetime local format
            if (td.deadline) {
                let d = new Date(td.deadline);
                let formatted = d.getFullYear() + '-' + 
                                String(d.getMonth()+1).padStart(2, '0') + '-' + 
                                String(d.getDate()).padStart(2, '0') + 'T' + 
                                String(d.getHours()).padStart(2, '0') + ':' + 
                                String(d.getMinutes()).padStart(2, '0');
                document.getElementById('tugas-deadline').value = formatted;
            }
            
            document.getElementById('tugas-file').required = false;
            document.getElementById('tugas-submit-btn').innerHTML = '<i class="fas fa-save"></i> Perbarui';
            document.getElementById('tugas-submit-btn').className = 'btn btn-edit';
            document.getElementById('tugas-cancel-btn').style.display = 'inline-flex';
        }

        function resetTugasForm() {
            document.getElementById('tugas-form-title').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Tugas Dosen';
            document.getElementById('tugas-form').action = '{{ route("admin.tugas.store") }}';
            
            document.getElementById('tugas-mk').value = '';
            document.getElementById('tugas-judul').value = '';
            document.getElementById('tugas-penjelasan').value = '';
            document.getElementById('tugas-deadline').value = '';
            
            document.getElementById('tugas-file').required = false;
            document.getElementById('tugas-submit-btn').innerHTML = '<i class="fas fa-plus"></i> Simpan Tugas';
            document.getElementById('tugas-submit-btn').className = 'btn btn-add';
            document.getElementById('tugas-cancel-btn').style.display = 'none';
        }

        // --- NILAI JS ---
        function editNilai(nilaiObj) {
            document.getElementById('nilai-form-title').innerHTML = '<i class="fas fa-edit"></i> Edit Nilai';
            document.getElementById('nilai-form').action = '/admin/nilai/update/' + nilaiObj.id;
            
            document.getElementById('nilai-user').value = nilaiObj.user_id;
            document.getElementById('nilai-mk').value = nilaiObj.mata_kuliah;
            
            document.getElementById('nilai-presensi').value = nilaiObj.nilai_presensi !== null ? nilaiObj.nilai_presensi : '';
            document.getElementById('nilai-tugas').value = nilaiObj.nilai_tugas !== null ? nilaiObj.nilai_tugas : '';
            document.getElementById('nilai-uts').value = nilaiObj.nilai_uts !== null ? nilaiObj.nilai_uts : '';
            document.getElementById('nilai-uas').value = nilaiObj.nilai_uas !== null ? nilaiObj.nilai_uas : '';
            
            // Hide selection groups during edit to prevent changing user/course directly
            document.getElementById('nilai-user-group').style.display = 'none';
            document.getElementById('nilai-mk-group').style.display = 'none';
            document.getElementById('nilai-user').required = false;
            document.getElementById('nilai-mk').required = false;
            
            document.getElementById('nilai-submit-btn').innerHTML = '<i class="fas fa-save"></i> Perbarui';
            document.getElementById('nilai-submit-btn').className = 'btn btn-edit';
            document.getElementById('nilai-cancel-btn').style.display = 'inline-flex';
        }

        function resetNilaiForm() {
            document.getElementById('nilai-form-title').innerHTML = '<i class="fas fa-star"></i> Kelola Nilai';
            document.getElementById('nilai-form').action = '{{ route("admin.nilai.store") }}';
            
            document.getElementById('nilai-user').value = '';
            document.getElementById('nilai-mk').value = '';
            
            document.getElementById('nilai-presensi').value = '';
            document.getElementById('nilai-tugas').value = '';
            document.getElementById('nilai-uts').value = '';
            document.getElementById('nilai-uas').value = '';
            
            document.getElementById('nilai-user-group').style.display = 'block';
            document.getElementById('nilai-mk-group').style.display = 'block';
            document.getElementById('nilai-user').required = true;
            document.getElementById('nilai-mk').required = true;
            
            document.getElementById('nilai-submit-btn').innerHTML = '<i class="fas fa-save"></i> Simpan Nilai';
            document.getElementById('nilai-submit-btn').className = 'btn btn-add';
            document.getElementById('nilai-cancel-btn').style.display = 'none';
        }

        // --- MATERI JS ---
        function editMateri(mat) {
            document.getElementById('materi-form-title').innerHTML = '<i class="fas fa-edit"></i> Edit Materi Kuliah';
            document.getElementById('materi-form').action = '/admin/materi/update/' + mat.id;
            
            document.getElementById('materi-mk').value = mat.mata_kuliah;
            document.getElementById('materi-pertemuan').value = mat.pertemuan;
            document.getElementById('materi-judul').value = mat.judul;
            document.getElementById('materi-deskripsi').value = mat.deskripsi ?? '';
            
            document.getElementById('materi-file').required = false;
            document.getElementById('materi-submit-btn').innerHTML = '<i class="fas fa-save"></i> Perbarui';
            document.getElementById('materi-submit-btn').className = 'btn btn-edit';
            document.getElementById('materi-cancel-btn').style.display = 'inline-flex';
        }

        function resetMateriForm() {
            document.getElementById('materi-form-title').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah / Upload Materi';
            document.getElementById('materi-form').action = '{{ route("admin.materi.store") }}';
            
            document.getElementById('materi-mk').value = '';
            document.getElementById('materi-pertemuan').value = '1';
            document.getElementById('materi-judul').value = '';
            document.getElementById('materi-deskripsi').value = '';
            
            document.getElementById('materi-file').required = true;
            document.getElementById('materi-submit-btn').innerHTML = '<i class="fas fa-plus"></i> Simpan Materi';
            document.getElementById('materi-submit-btn').className = 'btn btn-add';
            document.getElementById('materi-cancel-btn').style.display = 'none';
        }
    </script>

    <!-- ========================================== -->
    <!-- MODAL IMPOR NILAI EXCEL (ADMIN) -->
    <!-- ========================================== -->
    <div id="excel-modal" class="modal" style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
        <div class="modal-content" style="background: white; padding: 2rem; border-radius: 12px; max-width: 600px; width: 90%; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3><i class="fas fa-file-excel"></i> Impor Nilai Mahasiswa (Admin)</h3>
                <button type="button" class="close-btn" onclick="closeExcelModal()" style="font-size: 1.5rem; cursor: pointer; border: none; background: transparent;">&times;</button>
            </div>
            
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f0fdfa; border-left: 4px solid #22c55e; border-radius: 4px; font-size: 0.85rem; line-height: 1.5;">
                <strong>Format File Excel:</strong><br>
                Harus memiliki kolom header persis berikut:<br>
                <code>Email</code> (email mahasiswa) | <code>Presensi</code> | <code>Tugas</code> | <code>UTS</code> | <code>UAS</code><br>
                <a href="#" onclick="downloadGradesTemplate(); return false;" style="color:#0369a1; text-decoration:underline; font-weight:bold; display:block; margin-top:0.5rem;">Unduh Template Nilai (.xlsx)</a>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="excel-course-select">Pilih Mata Kuliah Tujuan Impor</label>
                <select id="excel-course-select" required>
                    <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                    @foreach($mataKuliah as $mk)
                        <option value="{{ $mk->nama }}">{{ $mk->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="excel-file-input">Pilih File Excel/CSV (.xlsx, .xls, .csv)</label>
                <input type="file" id="excel-file-input" accept=".xlsx, .xls, .csv" onchange="handleExcelFile(event)">
            </div>

            <div id="excel-preview-section" style="display:none; max-height:180px; overflow-y:auto; margin-bottom:1.5rem; border:1px solid #e5e7eb; border-radius:8px;">
                <table style="font-size:0.8rem; width:100%; border-collapse:collapse;">
                    <thead style="background:#f3f4f6; color:#374151;">
                        <tr>
                            <th style="padding:0.4rem; border-bottom:1px solid #ddd;">Email</th>
                            <th style="padding:0.4rem; border-bottom:1px solid #ddd; text-align:center;">Presensi</th>
                            <th style="padding:0.4rem; border-bottom:1px solid #ddd; text-align:center;">Tugas</th>
                            <th style="padding:0.4rem; border-bottom:1px solid #ddd; text-align:center;">UTS</th>
                            <th style="padding:0.4rem; border-bottom:1px solid #ddd; text-align:center;">UAS</th>
                        </tr>
                    </thead>
                    <tbody id="excel-preview-rows">
                        <!-- Preview rows -->
                    </tbody>
                </table>
            </div>

            <form id="import-grades-form" action="{{ route('admin.nilai.import') }}" method="POST">
                @csrf
                <input type="hidden" name="mata_kuliah" id="import-grades-course">
                <input type="hidden" name="grades" id="import-grades-payload">
                
                <button type="submit" id="submit-excel-btn" class="btn btn-add" style="width: 100%; justify-content: center;" disabled>
					<i class="fas fa-upload"></i> Simpan & Terapkan Nilai
                </button>
            </form>
        </div>
    </div>

    <script>
        function openExcelModal() {
            document.getElementById('excel-modal').style.display = 'flex';
            document.getElementById('excel-file-input').value = '';
            document.getElementById('excel-preview-section').style.display = 'none';
            document.getElementById('submit-excel-btn').disabled = true;
        }

        function closeExcelModal() {
            document.getElementById('excel-modal').style.display = 'none';
        }

        function handleExcelFile(e) {
            const courseSelect = document.getElementById('excel-course-select');
            if (!courseSelect.value) {
                alert("Harap pilih mata kuliah tujuan terlebih dahulu!");
                e.target.value = '';
                return;
            }

            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(evt) {
                const data = evt.target.result;
                const workbook = XLSX.read(data, { type: 'binary' });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const json = XLSX.utils.sheet_to_json(worksheet);

                // Render Preview
                const previewBody = document.getElementById('excel-preview-rows');
                previewBody.innerHTML = '';

                if (json.length === 0) {
                    alert("File Excel kosong atau format tidak sesuai.");
                    return;
                }

                json.forEach(row => {
                    const email = row.Email || row.email || '';
                    const presensi = row.Presensi || row.presensi || '';
                    const tugas = row.Tugas || row.tugas || '';
                    const uts = row.UTS || row.uts || '';
                    const uas = row.UAS || row.uas || '';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="padding:0.4rem; border-bottom:1px solid #eee;">${email}</td>
                        <td style="padding:0.4rem; border-bottom:1px solid #eee; text-align:center;">${presensi}</td>
                        <td style="padding:0.4rem; border-bottom:1px solid #eee; text-align:center;">${tugas}</td>
                        <td style="padding:0.4rem; border-bottom:1px solid #eee; text-align:center;">${uts}</td>
                        <td style="padding:0.4rem; border-bottom:1px solid #eee; text-align:center;">${uas}</td>
                    `;
                    previewBody.appendChild(tr);
                });

                document.getElementById('excel-preview-section').style.display = 'block';
                document.getElementById('import-grades-course').value = courseSelect.value;
                document.getElementById('import-grades-payload').value = JSON.stringify(json);
                document.getElementById('submit-excel-btn').disabled = false;
            };
            reader.readAsBinaryString(file);
        }

        function downloadGradesTemplate() {
            const data = [
                ["Email", "Presensi", "Tugas", "UTS", "UAS"],
                ["rizky.pratama@mhs.clazzy.id", 95, 85, 90, 88]
            ];
            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Template Nilai");
            XLSX.writeFile(wb, "template_nilai.xlsx");
        }
    </script>
</body>
</html>

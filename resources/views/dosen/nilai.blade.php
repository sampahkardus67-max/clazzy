<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai & Presensi - Clazzy</title>
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
        .btn-save { background: #0891b2; color: white; border-color: #0891b2; }
        .btn-save:hover { background: #0e7490; border-color: #0e7490; }
        
        .tabs { background: white; padding: 0 2rem; display: flex; gap: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .tab:hover { color: #9333ea; }
        .tab.active { color: #9333ea; border-bottom-color: #9333ea; }
        
        .sub-tabs { display: flex; gap: 0; margin-bottom: 1.5rem; background: white; border-radius: 12px; padding: 0.4rem; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: fit-content; }
        .sub-tab { padding: 0.6rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; border: none; background: transparent; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; }
        .sub-tab.active { background: #9333ea; color: white; }
        .sub-tab:hover:not(.active) { background: #f3e8ff; color: #9333ea; }
        
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: #9333ea; }
        
        .flex-container { display: flex; gap: 2rem; align-items: flex-start; }
        .form-section { flex: 1.2; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; }
        .list-section { flex: 2; }
        
        h3 { margin-bottom: 1.5rem; font-size: 1.2rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; font-size: 0.9rem; }
        input[type="number"], select, input[type="text"] { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
        input[type="number"]:focus, select:focus, input[type="text"]:focus { outline: none; border-color: #0891b2; }
        
        /* Table Styling */
        .card-table { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #0891b2, #06b6d4); color: white; }
        th { padding: 1rem 1.5rem; text-align: left; font-weight: 600; }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdfa; }
        
        /* Attendance Radios */
        .attendance-options { display: flex; gap: 1rem; }
        .attendance-label { display: flex; align-items: center; gap: 0.25rem; cursor: pointer; font-weight: bold; }
        .badge-status { display: inline-block; width: 24px; height: 24px; border-radius: 50%; text-align: center; line-height: 24px; font-weight: bold; font-size: 0.8rem; color: white; }
        .status-H { background-color: #22c55e; }
        .status-I { background-color: #3b82f6; }
        .status-S { background-color: #eab308; }
        .status-A { background-color: #ef4444; }

        /* Grade Badges */
        .grade-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-align: center; text-transform: uppercase; }
        .grade-badge.a { background: #d1fae5; color: #065f46; }
        .grade-badge.b { background: #dbeafe; color: #1e40af; }
        .grade-badge.c { background: #fef3c7; color: #92400e; }
        .grade-badge.d { background: #fee2e2; color: #991b1b; }
        .grade-badge.e { background: #f3f4f6; color: #1f2937; }
        
        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #4caf50; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
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
            <span><strong>{{ auth()->user()->name }}</strong> (Dosen)</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </nav>

    <div class="tabs">
        <a href="{{ route('dashboard') }}" class="tab"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('dosen.mata-kuliah') }}" class="tab"><i class="fas fa-chalkboard-teacher"></i> Mata Kuliah Diajar</a>
        <a href="{{ route('dosen.materi') }}" class="tab"><i class="fas fa-book-open"></i> Upload Materi</a>
        <a href="{{ route('dosen.tugas') }}" class="tab"><i class="fas fa-tasks"></i> Tugas Baru</a>
        <a href="{{ route('dosen.nilai') }}" class="tab active"><i class="fas fa-edit"></i> Input Nilai</a>
        <a href="{{ route('dosen.jurnal-rps') }}" class="tab"><i class="fas fa-journal-whills"></i> Jurnal & RPS</a>
        <a href="{{ route('dosen.mahasiswa') }}" class="tab"><i class="fas fa-user-friends"></i> Daftar Mahasiswa</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-edit"></i> Manajemen Nilai & Presensi Mahasiswa</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Sub-tabs --}}
        <div class="sub-tabs">
            <button class="sub-tab active" onclick="switchTab('presensi')">
                <i class="fas fa-calendar-check"></i> Presensi Harian
            </button>
            <button class="sub-tab" onclick="switchTab('input-nilai')">
                <i class="fas fa-edit"></i> Input Nilai (Tugas/UTS/UAS)
            </button>
            <button class="sub-tab" onclick="switchTab('rekap')">
                <i class="fas fa-clipboard-list"></i> Rekap Nilai Akhir
            </button>
        </div>

        <!-- ========================================== -->
        <!-- TAB: PRESENSI MAHASISWA -->
        <!-- ========================================== -->
        <div id="panel-presensi" class="tab-panel active">
            <div class="flex-container">
                <div class="form-section">
                    <h3><i class="fas fa-calendar-alt"></i> Pilih Kelas & Pertemuan</h3>
                    <form action="{{ route('dosen.presensi.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="p-mk">Mata Kuliah</label>
                            <select name="mata_kuliah" id="p-mk" required onchange="filterPresensi()">
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($myCourses as $mc)
                                    <option value="{{ $mc->nama }}">{{ $mc->nama }} ({{ $mc->kode }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="p-pertemuan">Pertemuan</label>
                            <select name="pertemuan" id="p-pertemuan" required onchange="filterPresensi()">
                                @for($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}">Pertemuan {{ $i }} @if($i === 8) (UTS) @elseif($i === 16) (UAS) @endif</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div style="margin-top: 1.5rem;">
                            <h4>Daftar Absensi Mahasiswa</h4>
                            <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 1rem;">
                                @foreach($mahasiswa as $m)
                                    <div style="background: #fafafa; padding: 1rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                        <strong>{{ $m->name }}</strong>
                                        <div class="attendance-options">
                                            @php
                                                // Default status 'H'
                                                $currentStatus = 'H';
                                            @endphp
                                            <label class="attendance-label">
                                                <input type="radio" name="statuses[{{ $m->id }}]" value="H" checked> H
                                            </label>
                                            <label class="attendance-label">
                                                <input type="radio" name="statuses[{{ $m->id }}]" value="I"> I
                                            </label>
                                            <label class="attendance-label">
                                                <input type="radio" name="statuses[{{ $m->id }}]" value="S"> S
                                            </label>
                                            <label class="attendance-label">
                                                <input type="radio" name="statuses[{{ $m->id }}]" value="A"> A
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-save" style="width: 100%; justify-content: center; margin-top: 1.5rem; border-color: #0891b2;">
                            <i class="fas fa-save"></i> Simpan Presensi
                        </button>
                    </form>
                </div>

                <div class="list-section">
                    <h3><i class="fas fa-history"></i> Riwayat Presensi Terakhir</h3>
                    @if($presensiList->isEmpty())
                        <div class="empty" style="padding: 3rem;">
                            <i class="fas fa-calendar-times"></i>
                            <p>Belum ada riwayat kehadiran diinputkan.</p>
                        </div>
                    @else
                        <div class="card-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mahasiswa</th>
                                        <th>Mata Kuliah</th>
                                        <th>Pertemuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiList->take(15) as $p)
                                    <tr>
                                        <td><strong>{{ $p->user->name ?? 'Mahasiswa' }}</strong></td>
                                        <td>{{ $p->mata_kuliah }}</td>
                                        <td>Pertemuan {{ $p->pertemuan }}</td>
                                        <td><span class="badge-status status-{{ $p->status }}">{{ $p->status }}</span></td>
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
        <!-- TAB: INPUT NILAI (Tugas/UTS/UAS) -->
        <!-- ========================================== -->
        <div id="panel-input-nilai" class="tab-panel">
            <div class="flex-container">
                <!-- Form Input Nilai -->
                <div class="form-section">
                    <h3><i class="fas fa-file-signature"></i> Input Nilai</h3>
                    
                    {{-- Toggle Form Tipe Input (Pertemuan vs UTS/UAS) --}}
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem;">
                        <button type="button" class="btn btn-action" id="btn-input-pertemuan" onclick="toggleTipeInput('pertemuan')" style="flex:1; justify-content:center; background:#9333ea; color:white; border-color:#9333ea;">Pertemuan</button>
                        <button type="button" class="btn btn-action" id="btn-input-akhir" onclick="toggleTipeInput('akhir')" style="flex:1; justify-content:center;">UTS / UAS</button>
                    </div>

                    {{-- FORM 1: Input Nilai Keaktifan / Tugas Pertemuan --}}
                    <form id="form-nilai-pertemuan" action="{{ route('dosen.nilai.store-pertemuan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="np-user">Mahasiswa</label>
                            <select name="user_id" id="np-user" required>
                                <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="np-mk">Mata Kuliah</label>
                            <select name="mata_kuliah" id="np-mk" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($myCourses as $mc)
                                    <option value="{{ $mc->nama }}">{{ $mc->nama }} ({{ $mc->kode }})</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="tipe" id="np-tipe" value="tugas">
                        <div class="form-group">
                            <label for="np-pertemuan">Pertemuan</label>
                            <select name="pertemuan" id="np-pertemuan" required>
                                @for($i = 1; $i <= 16; $i++)
                                    @if($i !== 8 && $i !== 16)
                                        <option value="{{ $i }}">Pertemuan {{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="np-skor">Skor Nilai Tugas & Keaktifan (0 - 100)</label>
                            <input type="number" name="skor" id="np-skor" min="0" max="100" placeholder="Skor" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-save" style="width: 100%; justify-content: center; border-color: #0891b2;">
                            <i class="fas fa-save"></i> Simpan Nilai Pertemuan
                        </button>
                    </form>

                    {{-- FORM 2: Input Nilai UTS / UAS (Hidden by default) --}}
                    <form id="form-nilai-akhir" action="{{ route('dosen.nilai.store') }}" method="POST" style="display: none;">
                        @csrf
                        <div class="form-group">
                            <label for="na-user">Mahasiswa</label>
                            <select name="user_id" id="na-user">
                                <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="na-mk">Mata Kuliah</label>
                            <select name="mata_kuliah" id="na-mk">
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($myCourses as $mc)
                                    <option value="{{ $mc->nama }}">{{ $mc->nama }} ({{ $mc->kode }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="na-tipe">Tipe Evaluasi</label>
                            <select name="tipe" id="na-tipe">
                                <option value="uts">Nilai UTS (Ujian Tengah Semester)</option>
                                <option value="uas">Nilai UAS (Ujian Akhir Semester)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="na-skor">Skor (0 - 100)</label>
                            <input type="number" name="skor" id="na-skor" min="0" max="100" placeholder="Skor" step="0.01">
                        </div>
                        <button type="submit" class="btn btn-save" style="width: 100%; justify-content: center; border-color: #0891b2;">
                            <i class="fas fa-save"></i> Simpan Nilai Ujian
                        </button>
                    </form>
                </div>

                <!-- Riwayat Nilai Pertemuan -->
                <div class="list-section">
                    <h3><i class="fas fa-history"></i> Riwayat Input Nilai Pertemuan</h3>
                    @if($nilaiPertemuanList->isEmpty())
                        <div class="empty" style="padding: 3rem;">
                            <i class="fas fa-folder-open"></i>
                            <p>Belum ada nilai pertemuan dimasukkan.</p>
                        </div>
                    @else
                        <div class="card-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mahasiswa</th>
                                        <th>Mata Kuliah</th>
                                        <th>Pertemuan</th>
                                        <th>Nilai Tugas & Keaktifan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiPertemuanList->take(15) as $np)
                                    <tr>
                                        <td><strong>{{ $np->user->name ?? 'Mahasiswa' }}</strong></td>
                                        <td>{{ $np->mata_kuliah }}</td>
                                        <td>Pertemuan {{ $np->pertemuan }}</td>
                                        <td><strong>{{ $np->nilai_tugas ?? '-' }}</strong></td>
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
        <!-- TAB: REKAP NILAI AKHIR (KOMPLET) -->
        <!-- ========================================== -->
        <div id="panel-rekap" class="tab-panel">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:1rem;">
                <div>
                    <h3><i class="fas fa-clipboard-list"></i> Rekapitulasi Nilai Akhir Mahasiswa</h3>
                    <p style="color:#6b7280; font-size:0.9rem; margin-top:0.25rem;">
                        Hitungan Bobot: <strong>Presensi (20%) + Tugas & Keaktifan (20%) + UTS (25%) + UAS (35%)</strong>.
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-excel btn-action" onclick="openExcelModal()">
                        <i class="fas fa-file-excel"></i> Impor Nilai Excel
                    </button>
                </div>
            </div>

            @if($nilaiList->isEmpty())
                <div class="empty">
                    <i class="fas fa-scroll"></i>
                    <p>Belum ada nilai mahasiswa yang diproses.</p>
                </div>
            @else
                <div class="card-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Mata Kuliah</th>
                                <th style="text-align: center;">Presensi (20%)</th>
                                <th style="text-align: center;">Tugas & Keaktifan (20%)</th>
                                <th style="text-align: center;">UTS (25%)</th>
                                <th style="text-align: center;">UAS (35%)</th>
                                <th style="text-align: center;">Total Nilai</th>
                                <th style="text-align: center;">Akreditasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiList as $n)
                            @php
                                $gradeClass = strtolower(str_replace('+', 'plus', str_replace('-', 'minus', $n->akreditasi ?? 'e')));
                            @endphp
                            <tr>
                                <td><strong>{{ $n->user->name ?? 'Mahasiswa' }}</strong></td>
                                <td>{{ $n->mata_kuliah }}</td>
                                <td style="text-align: center;"><strong>{{ number_format($n->nilai_presensi ?? 0, 1) }}</strong></td>
                                <td style="text-align: center;"><strong>{{ number_format($n->nilai_tugas ?? 0, 1) }}</strong></td>
                                <td style="text-align: center;"><strong>{{ number_format($n->nilai_uts ?? 0, 1) }}</strong></td>
                                <td style="text-align: center;"><strong>{{ number_format($n->nilai_uas ?? 0, 1) }}</strong></td>
                                <td style="text-align: center;"><strong style="color: #9333ea; font-size:1.05rem;">{{ number_format($n->total_nilai ?? 0, 2) }}</strong></td>
                                <td style="text-align: center;">
                                    <span class="grade-badge {{ strtolower(substr($n->akreditasi ?? 'e', 0, 1)) }}">{{ $n->akreditasi ?? 'E' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL IMPOR NILAI EXCEL -->
    <!-- ========================================== -->
    <div id="excel-modal" class="modal" style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
        <div class="modal-content" style="background: white; padding: 2rem; border-radius: 12px; max-width: 600px; width: 90%; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3><i class="fas fa-file-excel"></i> Impor Nilai Mahasiswa</h3>
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
                    @foreach($myCourses as $mc)
                        <option value="{{ $mc->nama }}">{{ $mc->nama }}</option>
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

            <form id="import-grades-form" action="{{ route('dosen.nilai.import') }}" method="POST">
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
    <script>
        function switchTab(name) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.sub-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('panel-' + name).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function toggleTipeInput(tipe) {
            const formPertemuan = document.getElementById('form-nilai-pertemuan');
            const formAkhir = document.getElementById('form-nilai-akhir');
            const btnPertemuan = document.getElementById('btn-input-pertemuan');
            const btnAkhir = document.getElementById('btn-input-akhir');
            
            if (tipe === 'pertemuan') {
                formPertemuan.style.display = 'block';
                formAkhir.style.display = 'none';
                
                // Form requirements toggling
                document.getElementById('np-user').required = true;
                document.getElementById('np-mk').required = true;
                document.getElementById('np-tipe').required = true;
                document.getElementById('np-pertemuan').required = true;
                document.getElementById('np-skor').required = true;

                document.getElementById('na-user').required = false;
                document.getElementById('na-mk').required = false;
                document.getElementById('na-tipe').required = false;
                document.getElementById('na-skor').required = false;

                btnPertemuan.style.background = '#9333ea';
                btnPertemuan.style.color = 'white';
                btnPertemuan.style.borderColor = '#9333ea';
                btnAkhir.style.background = 'white';
                btnAkhir.style.color = '#333';
                btnAkhir.style.borderColor = '#d1d5db';
            } else {
                formPertemuan.style.display = 'none';
                formAkhir.style.display = 'block';

                // Form requirements toggling
                document.getElementById('np-user').required = false;
                document.getElementById('np-mk').required = false;
                document.getElementById('np-tipe').required = false;
                document.getElementById('np-pertemuan').required = false;
                document.getElementById('np-skor').required = false;

                document.getElementById('na-user').required = true;
                document.getElementById('na-mk').required = true;
                document.getElementById('na-tipe').required = true;
                document.getElementById('na-skor').required = true;

                btnAkhir.style.background = '#9333ea';
                btnAkhir.style.color = 'white';
                btnAkhir.style.borderColor = '#9333ea';
                btnPertemuan.style.background = 'white';
                btnPertemuan.style.color = '#333';
                btnPertemuan.style.borderColor = '#d1d5db';
            }
        }
        
        function filterPresensi() {
            // Optional front-end logic to filter students/status per class selection
        }
    </script>
</body>
</html>

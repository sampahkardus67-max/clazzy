<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tugas - Clazzy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .btn-upload { background: #9333ea; color: white; border-color: #9333ea; }
        .btn-upload:hover { background: #7e22ce; border-color: #7e22ce; }
        .btn-download { background: #0891b2; color: white; border-color: #0891b2; padding: 0.4rem 1rem; font-size: 0.85rem; }
        .btn-download:hover { background: #0e7490; border-color: #0e7490; }
        
        .tabs { background: white; padding: 0 2rem; display: flex; gap: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .tab:hover { color: #9333ea; }
        .tab.active { color: #9333ea; border-bottom-color: #9333ea; }
        
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: #9333ea; }
        
        .sub-tabs { display: flex; gap: 0; margin-bottom: 1.5rem; background: white; border-radius: 12px; padding: 0.4rem; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: fit-content; }
        .sub-tab { padding: 0.6rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; border: none; background: transparent; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; }
        .sub-tab.active { background: #9333ea; color: white; }
        .sub-tab:hover:not(.active) { background: #f3e8ff; color: #9333ea; }
        
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
        
        /* Grid Layout */
        .flex-container { display: flex; gap: 2rem; align-items: flex-start; }
        .form-section { flex: 1.2; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; }
        .list-section { flex: 2; }
        
        /* Form Styling */
        h3 { margin-bottom: 1.5rem; font-size: 1.2rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; font-size: 0.9rem; }
        input[type="text"], select, textarea, input[type="datetime-local"] { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
        input[type="text"]:focus, select:focus, textarea:focus, input[type="datetime-local"]:focus { outline: none; border-color: #9333ea; }
        textarea { resize: vertical; min-height: 100px; }
        .file-input-wrapper { border: 2px dashed #d1d5db; border-radius: 8px; padding: 1.5rem; text-align: center; background: #f9fafb; cursor: pointer; }
        
        /* Tugas Cards */
        .tugas-grid { display: flex; flex-direction: column; gap: 1rem; }
        .tugas-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1.5rem; border-left: 5px solid #9333ea; }
        .tugas-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; }
        .tugas-header h4 { font-size: 1.1rem; font-weight: 700; color: #1f2937; }
        .tugas-body { color: #4b5563; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1rem; }
        .tugas-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 0.75rem; font-size: 0.85rem; color: #6b7280; }
        .mk-badge { background: #f3e8ff; color: #7e22ce; padding: 0.2rem 0.6rem; border-radius: 20px; font-weight: 600; }
        
        /* Submission Table */
        .card-table { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #9333ea, #a855f7); color: white; }
        th { padding: 1rem 1.5rem; text-align: left; font-weight: 600; }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf5ff; }
        
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
        <a href="{{ route('dosen.tugas') }}" class="tab active"><i class="fas fa-tasks"></i> Tugas Baru</a>
        <a href="{{ route('dosen.nilai') }}" class="tab"><i class="fas fa-edit"></i> Input Nilai</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-tasks"></i> Manajemen Tugas Kuliah</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Sub-tab --}}
        <div class="sub-tabs">
            <button class="sub-tab active" onclick="switchTab('tugas-diajar')">
                <i class="fas fa-edit"></i> Berikan Tugas
            </button>
            <button class="sub-tab" onclick="switchTab('kiriman-mahasiswa')">
                <i class="fas fa-inbox"></i> Tugas Mahasiswa
            </button>
        </div>

        {{-- Panel: Berikan Tugas --}}
        <div id="panel-tugas-diajar" class="tab-panel active">
            <div class="flex-container">
                <!-- Form upload tugas dosen -->
                <div class="form-section">
                    <h3><i class="fas fa-plus-circle"></i> Buat Tugas Baru</h3>
                    <form action="{{ route('dosen.tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="mata_kuliah">Mata Kuliah</label>
                            <select name="mata_kuliah" id="mata_kuliah" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach($myCourses as $mc)
                                    <option value="{{ $mc }}" {{ request('mata_kuliah') == $mc ? 'selected' : '' }}>{{ $mc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="judul">Judul Tugas</label>
                            <input type="text" name="judul" id="judul" placeholder="Contoh: Tugas 1: Algoritma Sorting" required>
                        </div>
                        <div class="form-group">
                            <label for="penjelasan">Instruksi Tugas</label>
                            <textarea name="penjelasan" id="penjelasan" placeholder="Tulis instruksi tugas di sini..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Batas Waktu (Deadline)</label>
                            <input type="datetime-local" name="deadline" id="deadline" required>
                        </div>
                        <div class="form-group">
                            <label>Lampiran File (Opsional)</label>
                            <input type="file" name="file">
                        </div>
                        <button type="submit" class="btn btn-upload" style="width: 100%; justify-content: center;">
                            <i class="fas fa-paper-plane"></i> Publikasikan Tugas
                        </button>
                    </form>
                </div>

                <!-- Daftar tugas yang pernah dibuat -->
                <div class="list-section">
                    <h3><i class="fas fa-list-ul"></i> Daftar Tugas yang Diterbitkan</h3>
                    @if($tugasDosen->isEmpty())
                        <div class="empty" style="padding: 3rem;">
                            <i class="fas fa-tasks"></i>
                            <p>Anda belum menerbitkan tugas apa pun.</p>
                        </div>
                    @else
                        <div class="tugas-grid">
                            @foreach($tugasDosen as $td)
                                <div class="tugas-card">
                                    <div class="tugas-header">
                                        <h4>{{ $td->judul }}</h4>
                                        <span class="mk-badge">{{ $td->mata_kuliah }}</span>
                                    </div>
                                    <div class="tugas-body">
                                        <p>{{ $td->penjelasan }}</p>
                                    </div>
                                    <div class="tugas-footer">
                                        <span><i class="fas fa-clock"></i> Deadline: <strong>{{ $td->deadline->format('d M Y, H:i') }}</strong></span>
                                        @if($td->file_path)
                                            <a href="{{ asset('storage/' . $td->file_path) }}" class="btn btn-download" style="padding: 0.2rem 0.6rem; font-size: 0.8rem;" download>
                                                <i class="fas fa-paperclip"></i> Unduh Lampiran
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel: Tugas Mahasiswa --}}
        <div id="panel-kiriman-mahasiswa" class="tab-panel">
            <h3><i class="fas fa-inbox"></i> Kiriman Jawaban Mahasiswa</h3>
            @if($tugasMahasiswa->isEmpty())
                <div class="empty">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada mahasiswa yang mengumpulkan tugas.</p>
                </div>
            @else
                <div class="card-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nama File</th>
                                <th>Tanggal Kirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tugasMahasiswa as $i => $tm)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $tm->user->name ?? 'Mahasiswa' }}</strong><br><span style="font-size:0.8rem; color:#6b7280;">{{ $tm->user->email }}</span></td>
                                <td><i class="fas fa-file-pdf" style="color:#d32f2f; margin-right:0.5rem;"></i>{{ $tm->nama }}</td>
                                <td>{{ $tm->created_at->format('d F Y, H:i') }}</td>
                                <td>
                                    <!-- Button download submissions -->
                                    <a href="{{ route('tugas.download', $tm->id) }}" class="btn btn-download">
                                        <i class="fas fa-download"></i> Unduh Berkas
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(name) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.sub-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('panel-' + name).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>

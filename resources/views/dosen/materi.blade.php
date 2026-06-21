<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Materi Kuliah - Clazzy</title>
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
        .btn-danger { background: #ef4444; color: white; border-color: #ef4444; padding: 0.4rem 1rem; font-size: 0.85rem; }
        .btn-danger:hover { background: #dc2626; border-color: #dc2626; }
        
        .tabs { background: white; padding: 0 2rem; display: flex; gap: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .tab:hover { color: #9333ea; }
        .tab.active { color: #9333ea; border-bottom-color: #9333ea; }
        
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: #9333ea; }
        
        .flex-container { display: flex; gap: 2rem; align-items: flex-start; }
        .form-section { flex: 1.2; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; }
        .list-section { flex: 2; }
        
        h3 { margin-bottom: 1.5rem; font-size: 1.2rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; font-size: 0.9rem; }
        input[type="text"], select, textarea { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
        input[type="text"]:focus, select:focus, textarea:focus { outline: none; border-color: #9333ea; }
        textarea { resize: vertical; min-height: 100px; }
        
        /* Table Styling */
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
        
        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .badge-info { background: #ede9fe; color: #7c3aed; }
        .badge-pertemuan { background: #e0f2fe; color: #0369a1; }
        
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
        <a href="{{ route('dosen.materi') }}" class="tab active"><i class="fas fa-book-open"></i> Upload Materi</a>
        <a href="{{ route('dosen.tugas') }}" class="tab"><i class="fas fa-tasks"></i> Tugas Baru</a>
        <a href="{{ route('dosen.nilai') }}" class="tab"><i class="fas fa-edit"></i> Input Nilai</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-book-open"></i> Manajemen Materi Pembelajaran</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="flex-container">
            <!-- Form Upload Materi -->
            <div class="form-section">
                <h3><i class="fas fa-cloud-upload-alt"></i> Upload Materi Baru</h3>
                <form action="{{ route('dosen.materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="mata_kuliah">Mata Kuliah</label>
                        <select name="mata_kuliah" id="mata_kuliah" required>
                            <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                            @foreach($myCourses as $mc)
                                <option value="{{ $mc->nama }}">{{ $mc->nama }} ({{ $mc->kode }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pertemuan">Pertemuan Ke-</label>
                        <select name="pertemuan" id="pertemuan" required>
                            <option value="" disabled selected>-- Pilih Pertemuan --</option>
                            @for($i = 1; $i <= 16; $i++)
                                <option value="{{ $i }}">Pertemuan {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Materi</label>
                        <input type="text" name="judul" id="judul" placeholder="Contoh: Pengenalan Object Oriented Programming" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Singkat (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" placeholder="Tulis ringkasan materi atau petunjuk membaca di sini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">File Dokumen (PDF, PPT, Word, dll.)</label>
                        <input type="file" name="file" id="file" required>
                    </div>
                    <button type="submit" class="btn btn-upload" style="width: 100%; justify-content: center;">
                        <i class="fas fa-upload"></i> Unggah Materi
                    </button>
                </form>
            </div>

            <!-- Daftar Materi yang Pernah Diupload -->
            <div class="list-section">
                <h3><i class="fas fa-list"></i> Daftar Materi Terunggah</h3>
                @if($materiList->isEmpty())
                    <div class="empty" style="padding: 3rem;">
                        <i class="fas fa-folder-open"></i>
                        <p>Belum ada materi kuliah yang diunggah.</p>
                    </div>
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
                                @foreach($materiList as $materi)
                                <tr>
                                    <td>
                                        <span class="badge badge-pertemuan">Pertemuan {{ $materi->pertemuan }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info" style="margin-bottom:0.3rem;">{{ $materi->mata_kuliah }}</span><br>
                                        <strong>{{ $materi->judul }}</strong>
                                        @if($materi->deskripsi)
                                            <p style="font-size:0.85rem; color:#6b7280; margin-top:0.2rem;">{{ $materi->deskripsi }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex; gap:0.5rem;">
                                            <a href="{{ asset('storage/' . $materi->file_path) }}" class="btn btn-download" style="padding:0.3rem 0.6rem; font-size:0.8rem;" download>
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                            <form action="{{ route('dosen.materi.delete', $materi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" style="padding:0.3rem 0.6rem; font-size:0.8rem;">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
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
</body>
</html>

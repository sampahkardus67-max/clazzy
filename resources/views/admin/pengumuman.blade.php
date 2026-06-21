<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengumuman - Admin Clazzy</title>
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

        .flex-container { display: flex; gap: 2rem; align-items: flex-start; }
        .form-section { flex: 1.2; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; }
        .list-section { flex: 2; }
        
        h3 { margin-bottom: 1.5rem; font-size: 1.2rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; font-size: 0.9rem; }
        input[type="text"], textarea { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
        input[type="text"]:focus, textarea:focus { outline: none; border-color: #9333ea; }
        textarea { resize: vertical; min-height: 150px; }

        /* Announcement Cards */
        .ann-grid { display: flex; flex-direction: column; gap: 1rem; }
        .ann-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1.5rem; border-left: 5px solid #9333ea; }
        .ann-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; }
        .ann-header h4 { font-size: 1.15rem; font-weight: 700; color: #1f2937; }
        .ann-meta { font-size: 0.8rem; color: #6b7280; margin-bottom: 1rem; display: block; }
        .ann-body { color: #4b5563; font-size: 0.95rem; line-height: 1.6; white-space: pre-line; margin-bottom: 1rem; }
        .ann-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 0.75rem; }

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
        <a href="{{ route('admin.kelas') }}" class="tab"><i class="fas fa-book-open"></i> Manajemen Kelas</a>
        <a href="{{ route('admin.pengumuman') }}" class="tab active"><i class="fas fa-bullhorn"></i> Pengumuman</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-bullhorn"></i> Manajemen Pengumuman Akademik</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="flex-container">
            <!-- Form Input/Edit Pengumuman -->
            <div class="form-section">
                <h3 id="form-title"><i class="fas fa-bullhorn"></i> Buat Pengumuman Baru</h3>
                <form id="ann-form" action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Judul Pengumuman</label>
                        <input type="text" name="title" id="title" placeholder="Contoh: Jadwal Ujian Akhir Semester" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Isi Pengumuman</label>
                        <textarea name="content" id="content" placeholder="Tuliskan isi pengumuman secara rinci di sini..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Lampiran File (Opsional)</label>
                        <input type="file" name="file" id="file">
                    </div>
                    <button type="submit" id="submit-btn" class="btn btn-add" style="width: 100%; justify-content: center;">
                        <i class="fas fa-paper-plane"></i> Publikasikan
                    </button>
                    <button type="button" id="cancel-btn" class="btn" style="width: 100%; justify-content: center; margin-top: 0.5rem; display: none;" onclick="resetForm()">
                        Batal Edit
                    </button>
                </form>
            </div>

            <!-- Daftar Pengumuman -->
            <div class="list-section">
                <h3><i class="fas fa-list"></i> Riwayat Pengumuman</h3>
                @if($announcements->isEmpty())
                    <div class="empty">
                        <i class="fas fa-bullhorn"></i>
                        <p>Belum ada pengumuman yang diterbitkan.</p>
                    </div>
                @else
                    <div class="ann-grid">
                        @foreach($announcements as $ann)
                            <div class="ann-card">
                                <div class="ann-header">
                                    <h4>{{ $ann->title }}</h4>
                                </div>
                                <span class="ann-meta">Diterbitkan pada {{ $ann->created_at->format('d M Y, H:i') }}</span>
                                <div class="ann-body">
                                    {{ $ann->content }}
                                </div>
                                <div class="ann-footer">
                                    <div>
                                        @if($ann->file_path)
                                            <a href="{{ route('announcements.download', $ann->id) }}" class="btn btn-action btn-download" download>
                                                <i class="fas fa-download"></i> Unduh Lampiran
                                            </a>
                                        @endif
                                    </div>
                                    <div style="display:flex; gap:0.5rem;">
                                        <button type="button" class="btn btn-action btn-edit" onclick="editAnnouncement({{ json_encode($ann) }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.pengumuman.delete', $ann->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-action btn-danger">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function editAnnouncement(ann) {
            document.getElementById('form-title').innerHTML = '<i class="fas fa-edit"></i> Edit Pengumuman';
            document.getElementById('ann-form').action = '/admin/pengumuman/update/' + ann.id;
            
            document.getElementById('title').value = ann.title;
            document.getElementById('content').value = ann.content;
            
            document.getElementById('submit-btn').innerHTML = '<i class="fas fa-save"></i> Perbarui';
            document.getElementById('submit-btn').className = 'btn btn-edit';
            document.getElementById('cancel-btn').style.display = 'inline-flex';
        }

        function resetForm() {
            document.getElementById('form-title').innerHTML = '<i class="fas fa-bullhorn"></i> Buat Pengumuman Baru';
            document.getElementById('ann-form').action = '{{ route("admin.pengumuman.store") }}';
            
            document.getElementById('title').value = '';
            document.getElementById('content').value = '';
            document.getElementById('file').value = '';
            
            document.getElementById('submit-btn').innerHTML = '<i class="fas fa-paper-plane"></i> Publikasikan';
            document.getElementById('submit-btn').className = 'btn btn-add';
            document.getElementById('cancel-btn').style.display = 'none';
        }
    </script>
</body>
</html>

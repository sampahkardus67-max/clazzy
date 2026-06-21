<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas - Clazzy</title>
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

        /* Navbar tabs (halaman utama) */
        .main-tabs { background: white; padding: 0 2rem; display: flex; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .main-tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .main-tab:hover { color: #9333ea; }
        .main-tab.active { color: #9333ea; border-bottom-color: #9333ea; }

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: #9333ea; }

        /* Sub-tabs di dalam halaman tugas */
        .sub-tabs { display: flex; gap: 0; margin-bottom: 1.5rem; background: white; border-radius: 12px; padding: 0.4rem; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: fit-content; }
        .sub-tab { padding: 0.6rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; border: none; background: transparent; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; }
        .sub-tab.active { background: #9333ea; color: white; }
        .sub-tab:hover:not(.active) { background: #f3e8ff; color: #9333ea; }

        /* Panel konten sub-tab */
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* Kartu tugas dosen */
        .tugas-dosen-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem; }
        .tugas-dosen-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; border-top: 4px solid #9333ea; }
        .tugas-dosen-card.urgent { border-top-color: #dc2626; }
        .tugas-dosen-card.soon { border-top-color: #f59e0b; }
        .tugas-dosen-card.safe { border-top-color: #16a34a; }
        .card-header { padding: 1.25rem 1.5rem 0.75rem; }
        .card-header .mk-badge { display: inline-block; background: #ede9fe; color: #7c3aed; padding: 0.2rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; }
        .card-header h3 { font-size: 1.1rem; font-weight: 700; }
        .card-body { padding: 0.75rem 1.5rem; }
        .card-body p { color: #555; font-size: 0.95rem; line-height: 1.6; }
        .card-footer { padding: 1rem 1.5rem; background: #fafafa; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; }
        .deadline-info { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; }
        .deadline-info i { color: #9333ea; }
        .deadline-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .deadline-badge.urgent { background: #fee2e2; color: #dc2626; }
        .deadline-badge.soon { background: #fef3c7; color: #d97706; }
        .deadline-badge.safe { background: #dcfce7; color: #16a34a; }

        /* Tabel tugas mahasiswa */
        .card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        .upload-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; margin-bottom: 2rem; }
        .upload-card h3 { margin-bottom: 1rem; font-size: 1.1rem; color: #555; }
        .upload-form { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
        .file-input { flex: 1; padding: 0.6rem 1rem; border: 2px dashed #d1d5db; border-radius: 8px; background: #fafafa; min-width: 200px; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #9333ea, #a855f7); color: white; }
        th { padding: 1rem 1.5rem; text-align: left; font-weight: 600; }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf5ff; }
        .empty { text-align: center; padding: 4rem; color: #999; }
        .empty i { font-size: 3rem; margin-bottom: 1rem; display: block; }
        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #4caf50; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-error { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">C</div>
            <span>Clazzy</span>
        </a>
        <div class="nav-right">
            <span><strong>{{ auth()->user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </nav>

    <div class="main-tabs">
        <a href="{{ route('dashboard') }}" class="main-tab"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('mata-kuliah') }}" class="main-tab"><i class="fas fa-book"></i> Mata Kuliah</a>
        <a href="{{ route('materi') }}" class="main-tab"><i class="fas fa-book-open"></i> Materi</a>
        <a href="{{ route('tugas') }}" class="main-tab active"><i class="fas fa-tasks"></i> Tugas</a>
        <a href="{{ route('nilai') }}" class="main-tab"><i class="fas fa-chart-line"></i> Nilai</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-tasks"></i> Tugas</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        {{-- Sub-tab --}}
        <div class="sub-tabs">
            <button class="sub-tab active" onclick="switchTab('dari-dosen')">
                <i class="fas fa-chalkboard-teacher"></i> Tugas dari Dosen
            </button>
            <button class="sub-tab" onclick="switchTab('kiriman-saya')">
                <i class="fas fa-upload"></i> Kiriman Saya
            </button>
        </div>

        {{-- Panel: Tugas dari Dosen --}}
        <div id="panel-dari-dosen" class="tab-panel active">
            @if($tugasDosen->isEmpty())
                <div class="empty" style="background:white; border-radius:12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada tugas dari dosen.</p>
                </div>
            @else
                <div class="tugas-dosen-grid">
                    @foreach($tugasDosen as $td)
                        @php
                            $now = now();
                            $diff = $now->diffInHours($td->deadline, false);
                            if ($diff < 0) $status = 'urgent';
                            elseif ($diff <= 48) $status = 'soon';
                            else $status = 'safe';

                            $labelMap = ['urgent' => 'Lewat Deadline', 'soon' => 'Segera', 'safe' => 'Masih Ada Waktu'];
                        @endphp
                        <div class="tugas-dosen-card {{ $status }}">
                            <div class="card-header">
                                <div class="mk-badge"><i class="fas fa-book"></i> {{ $td->mata_kuliah }}</div>
                                <h3>{{ $td->judul }}</h3>
                            </div>
                            <div class="card-body">
                                <p>{{ $td->penjelasan }}</p>
                            </div>
                            <div class="card-footer">
                                <div class="deadline-info">
                                    <i class="fas fa-clock"></i>
                                    <span>Deadline: <strong>{{ $td->deadline->format('d M Y, H:i') }}</strong></span>
                                </div>
                                <span class="deadline-badge {{ $status }}">{{ $labelMap[$status] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Panel: Kiriman Saya --}}
        <div id="panel-kiriman-saya" class="tab-panel">
            <div class="upload-card">
                <h3><i class="fas fa-upload"></i> Kirim Tugas</h3>
                <form action="{{ route('tugas.upload') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <input type="file" name="file" class="file-input" required>
                    <button type="submit" class="btn btn-upload"><i class="fas fa-paper-plane"></i> Kirim Tugas</button>
                </form>
            </div>

            <div class="card">
                @if($tugas->isEmpty())
                    <div class="empty">
                        <i class="fas fa-folder-open"></i>
                        <p>Belum ada tugas yang dikirim.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama File</th>
                                <th>Tanggal Kirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tugas as $i => $t)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><i class="fas fa-file" style="color:#9333ea; margin-right:0.5rem;"></i>{{ $t->nama }}</td>
                                <td>{{ $t->created_at->format('d F Y, H:i') }}</td>
                                <td>
                                    <a href="{{ route('tugas.download', $t->id) }}" class="btn btn-download">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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
    </script>
</body>
</html>
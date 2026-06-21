<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Kuliah - Clazzy</title>
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
        .btn-download { background: #9333ea; color: white; border-color: #9333ea; padding: 0.4rem 1rem; font-size: 0.85rem; }
        .btn-download:hover { background: #7e22ce; border-color: #7e22ce; }
        
        .tabs { background: white; padding: 0 2rem; display: flex; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .tab:hover { color: #9333ea; }
        .tab.active { color: #9333ea; border-bottom-color: #9333ea; }
        
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .page-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: #9333ea; }

        /* Grouping Section */
        .pertemuan-section { margin-bottom: 2.5rem; }
        .pertemuan-title { font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .pertemuan-title i { color: #0891b2; }

        .materi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem; }
        .materi-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; border-left: 5px solid #0891b2; }
        
        .materi-header { margin-bottom: 1rem; }
        .materi-header .mk-badge { display: inline-block; background: #e0f2fe; color: #0369a1; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; }
        .materi-header h4 { font-size: 1.1rem; font-weight: 700; color: #1f2937; }
        .materi-body { color: #4b5563; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.5rem; }
        
        .materi-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 0.75rem; }
        .file-info { display: flex; align-items: center; gap: 0.4rem; color: #6b7280; font-size: 0.85rem; }
        
        .empty { text-align: center; padding: 4rem; color: #999; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .empty i { font-size: 3rem; margin-bottom: 1rem; display: block; }
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

    <div class="tabs">
        <a href="{{ route('dashboard') }}" class="tab"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('mata-kuliah') }}" class="tab"><i class="fas fa-book"></i> Mata Kuliah</a>
        <a href="{{ route('materi') }}" class="tab active"><i class="fas fa-book-open"></i> Materi</a>
        <a href="{{ route('tugas') }}" class="tab"><i class="fas fa-tasks"></i> Tugas</a>
        <a href="{{ route('nilai') }}" class="tab"><i class="fas fa-chart-line"></i> Nilai</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-book-open"></i> Materi Pembelajaran</div>

        @if($materiList->isEmpty())
            <div class="empty">
                <i class="fas fa-folder-open"></i>
                <p>Belum ada materi kuliah yang dibagikan oleh dosen.</p>
            </div>
        @else
            @php
                $groupedMateri = $materiList->groupBy('pertemuan');
            @endphp

            @foreach($groupedMateri as $pertemuan => $items)
                <div class="pertemuan-section">
                    <div class="pertemuan-title">
                        <i class="fas fa-calendar-alt"></i> Pertemuan {{ $pertemuan }}
                    </div>
                    <div class="materi-grid">
                        @foreach($items as $materi)
                            <div class="materi-card">
                                <div>
                                    <div class="materi-header">
                                        <span class="mk-badge">{{ $materi->mata_kuliah }}</span>
                                        <h4>{{ $materi->judul }}</h4>
                                    </div>
                                    <div class="materi-body">
                                        <p>{{ $materi->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}</p>
                                    </div>
                                </div>
                                <div class="materi-footer">
                                    <span class="file-info"><i class="far fa-file-alt"></i> Dokumen Kuliah</span>
                                    <a href="{{ route('materi.download', $materi->id) }}" class="btn btn-download">
                                        <i class="fas fa-download"></i> Unduh Materi
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Clazzy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .navbar {
            background-color: #e0e0e0;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .logo-icon {
            background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-name {
            font-weight: 600;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: 2px solid #00bcd4;
            border-radius: 8px;
            background: white;
            color: #00bcd4;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background: #00bcd4;
            color: white;
        }

        .btn-logout {
            background: #d32f2f;
            color: white;
            border-color: #d32f2f;
        }

        .btn-logout:hover {
            background: #c62828;
            border-color: #c62828;
        }

        .btn-download {
            background: #9333ea;
            color: white;
            border-color: #9333ea;
            display: inline-flex;
        }

        .btn-download:hover {
            background: #7e22ce;
            border-color: #7e22ce;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .welcome-section {
            background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);
            color: white;
            padding: 3rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #4caf50;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card-icon {
            font-size: 2.5rem;
            color: #9333ea;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }

            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .welcome-section h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">C</div>
            <span>Clazzy</span>
        </div>
        <div class="user-info">
            <span class="user-name">Selamat datang, {{ auth()->user()->name }}!</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="welcome-section">
            <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p>Anda telah berhasil login sebagai <strong>{{ ucfirst(auth()->user()->role ?? 'mahasiswa') }}</strong> di aplikasi Clazzy</p>
        </div>

        <div class="dashboard-cards" style="margin-bottom: 2rem;">
            @if(auth()->user()->role === 'admin')
                <!-- Kartu Manajemen User -->
                <a href="{{ route('admin.users') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-users-cog"></i></div>
                        <div class="card-title">Manajemen User</div>
                        <div class="card-text">Kelola data mahasiswa, dosen, dan staf</div>
                    </div>
                </a>
                <!-- Kartu Manajemen Kelas -->
                <a href="{{ route('admin.kelas') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-book-open"></i></div>
                        <div class="card-title">Manajemen Kelas</div>
                        <div class="card-text">Kelola mata kuliah dan pengajar</div>
                    </div>
                </a>
                <!-- Kartu Jurnal & RPS -->
                <a href="{{ route('admin.jurnal-rps') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-journal-whills"></i></div>
                        <div class="card-title">Jurnal & RPS</div>
                        <div class="card-text">Pantau rencana & realisasi kuliah dosen</div>
                    </div>
                </a>
                <!-- Kartu Daftar Mahasiswa -->
                <a href="{{ route('admin.mahasiswa') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-user-friends"></i></div>
                        <div class="card-title">Daftar Mahasiswa</div>
                        <div class="card-text">Lihat data & nilai mahasiswa terdaftar</div>
                    </div>
                </a>
                <!-- Kartu Pengumuman -->
                <a href="{{ route('admin.pengumuman') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-bullhorn"></i></div>
                        <div class="card-title">Pengumuman</div>
                        <div class="card-text">Kirim pengumuman ke seluruh civitas</div>
                    </div>
                </a>
            @elseif(auth()->user()->role === 'dosen')
                <!-- Kartu Mata Kuliah Diajar -->
                <a href="{{ route('dosen.mata-kuliah') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="card-title">Mata Kuliah Diajar</div>
                        <div class="card-text">Lihat kelas dan jadwal mengajar Anda</div>
                    </div>
                </a>
                <!-- Kartu Input Nilai -->
                <a href="{{ route('dosen.nilai') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-edit"></i></div>
                        <div class="card-title">Input Nilai</div>
                        <div class="card-text">Kelola nilai tugas mahasiswa</div>
                    </div>
                </a>
                <!-- Kartu Jurnal & RPS -->
                <a href="{{ route('dosen.jurnal-rps') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-journal-whills"></i></div>
                        <div class="card-title">Jurnal & RPS</div>
                        <div class="card-text">Kelola RPS dan isi jurnal perkuliahan</div>
                    </div>
                </a>
                <!-- Kartu Daftar Mahasiswa -->
                <a href="{{ route('dosen.mahasiswa') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-user-friends"></i></div>
                        <div class="card-title">Daftar Mahasiswa</div>
                        <div class="card-text">Lihat mahasiswa terdaftar di kelas Anda</div>
                    </div>
                </a>
                <!-- Kartu Buat Tugas -->
                <a href="{{ route('dosen.tugas') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-folder-plus"></i></div>
                        <div class="card-title">Tugas Baru</div>
                        <div class="card-text">Buat dan unggah tugas kuliah baru</div>
                    </div>
                </a>
            @else
                <!-- Kartu Mata Kuliah -->
                <a href="{{ route('mata-kuliah') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-book"></i></div>
                        <div class="card-title">Mata Kuliah</div>
                        <div class="card-text">Lihat semua mata kuliah Anda</div>
                    </div>
                </a>

                <!-- Kartu Tugas -->
                <a href="{{ route('tugas') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-tasks"></i></div>
                        <div class="card-title">Tugas</div>
                        <div class="card-text">Daftar tugas yang harus dikerjakan</div>
                    </div>
                </a>

                <!-- Kartu Nilai -->
                <a href="{{ route('nilai') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="card-title">Nilai</div>
                        <div class="card-text">Lihat perkembangan akademik Anda</div>
                    </div>
                </a>
            @endif
        </div>

        <!-- Bagian Pengumuman (jika ada) -->
        @if(auth()->user()->role !== 'admin')
        <div class="card" style="margin-bottom: 2rem; text-align: left;">
            <h2 style="display:flex; align-items:center; gap:0.5rem;"><i class="fas fa-bullhorn" style="color: #9333ea;"></i> Pengumuman Terbaru</h2>
            @if($announcements->isEmpty())
                <p style="color: #666; margin-top: 1rem;">Belum ada pengumuman untuk saat ini.</p>
            @else
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    @foreach($announcements as $ann)
                        <div style="background: #faf5ff; border-left: 4px solid #9333ea; padding: 1.25rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <h3 style="font-size: 1.15rem; color: #1f2937; margin-bottom: 0.25rem; display:flex; align-items:center; gap:0.5rem;">{{ $ann->title }}</h3>
                            <span style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.75rem;">Diterbitkan pada {{ $ann->created_at->format('d M Y, H:i') }}</span>
                            <p style="color: #4b5563; font-size: 0.95rem; line-height: 1.6; white-space: pre-line;">{{ $ann->content }}</p>
                            @if($ann->file_path)
                                <div style="margin-top: 1rem;">
                                    <a href="{{ route('announcements.download', $ann->id) }}" class="btn btn-download" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" download>
                                        <i class="fas fa-download"></i> Unduh Lampiran
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        <div class="card">
            <h2>Informasi Akun</h2>
            <table style="width: 100%; margin-top: 1rem;">
                <tr>
                    <td style="text-align: left; padding: 0.5rem;"><strong>Nama:</strong></td>
                    <td style="text-align: left; padding: 0.5rem;">{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 0.5rem;"><strong>Email:</strong></td>
                    <td style="text-align: left; padding: 0.5rem;">{{ auth()->user()->email }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 0.5rem;"><strong>Role:</strong></td>
                    <td style="text-align: left; padding: 0.5rem;">{{ ucfirst(auth()->user()->role ?? 'mahasiswa') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 0.5rem;"><strong>Terdaftar sejak:</strong></td>
                    <td style="text-align: left; padding: 0.5rem;">{{ auth()->user()->created_at->format('d F Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

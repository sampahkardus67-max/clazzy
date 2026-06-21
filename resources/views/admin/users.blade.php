<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin Clazzy</title>
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
        input[type="text"], input[type="email"], input[type="password"], select { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus { outline: none; border-color: #9333ea; }
        
        /* Table Styling */
        .card-table { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #0891b2, #06b6d4); color: white; }
        th { padding: 1rem 1.5rem; text-align: left; font-weight: 600; }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdfa; }
        
        .role-badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
        .role-admin { background: #fee2e2; color: #991b1b; }
        .role-dosen { background: #e0f2fe; color: #0369a1; }
        .role-mahasiswa { background: #dcfce7; color: #16a34a; }
        
        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #4caf50; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        
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
        <a href="{{ route('admin.users') }}" class="tab active"><i class="fas fa-users-cog"></i> Manajemen User</a>
        <a href="{{ route('admin.kelas') }}" class="tab"><i class="fas fa-book-open"></i> Manajemen Kelas</a>
        <a href="{{ route('admin.pengumuman') }}" class="tab"><i class="fas fa-bullhorn"></i> Pengumuman</a>
    </div>

    <div class="container">
        <div class="page-title"><i class="fas fa-users-cog"></i> Manajemen Data User</div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="flex-container">
            <!-- Form Input/Edit User -->
            <div class="form-section">
                <h3 id="form-title"><i class="fas fa-user-plus"></i> Tambah User Baru</h3>
                <form id="user-form" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" placeholder="Masukkan nama lengkap..." required>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="contoh@clazzy.id" required>
                    </div>
                    <div class="form-group">
                        <label for="password" id="password-label">Password</label>
                        <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" required>
                        <small id="password-help" style="color:#6b7280; display:none; margin-top:0.25rem;">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                    <div class="form-group">
                        <label for="role">Hak Akses (Role)</label>
                        <select name="role" id="role" required>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" id="submit-btn" class="btn btn-add" style="width: 100%; justify-content: center;">
                        <i class="fas fa-user-plus"></i> Tambah User
                    </button>
                    <button type="button" id="cancel-btn" class="btn" style="width: 100%; justify-content: center; margin-top: 0.5rem; display: none;" onclick="resetForm()">
                        Batal Edit
                    </button>
                </form>
            </div>

            <!-- Daftar User -->
            <div class="list-section">
                <h3><i class="fas fa-users"></i> Daftar Dosen dan Mahasiswa</h3>
                <div class="card-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama & Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $i => $u)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $u->name }}</strong><br>
                                    <span style="font-size:0.85rem; color:#6b7280;">{{ $u->email }}</span>
                                </td>
                                <td>
                                    <span class="role-badge role-{{ $u->role }}">{{ $u->role }}</span>
                                </td>
                                <td>
                                    <div style="display:flex; gap:0.5rem;">
                                        <button type="button" class="btn btn-action btn-edit" onclick="editUser({{ json_encode($u) }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-action btn-danger">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editUser(user) {
            document.getElementById('form-title').innerHTML = '<i class="fas fa-user-edit"></i> Edit Data User';
            document.getElementById('user-form').action = '/admin/users/update/' + user.id;
            document.getElementById('form-method').value = 'POST'; // We use POST for routing updates
            
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            
            document.getElementById('password').required = false;
            document.getElementById('password').placeholder = 'Masukkan password baru saja';
            document.getElementById('password-help').style.display = 'block';
            
            document.getElementById('role').value = user.role;
            
            document.getElementById('submit-btn').innerHTML = '<i class="fas fa-save"></i> Perbarui User';
            document.getElementById('submit-btn').className = 'btn btn-edit';
            document.getElementById('cancel-btn').style.display = 'inline-flex';
        }

        function resetForm() {
            document.getElementById('form-title').innerHTML = '<i class="fas fa-user-plus"></i> Tambah User Baru';
            document.getElementById('user-form').action = '{{ route("admin.users.store") }}';
            document.getElementById('form-method').value = 'POST';
            
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            
            document.getElementById('password').required = true;
            document.getElementById('password').value = '';
            document.getElementById('password').placeholder = 'Minimal 6 karakter';
            document.getElementById('password-help').style.display = 'none';
            
            document.getElementById('role').value = 'mahasiswa';
            
            document.getElementById('submit-btn').innerHTML = '<i class="fas fa-user-plus"></i> Tambah User';
            document.getElementById('submit-btn').className = 'btn btn-add';
            document.getElementById('cancel-btn').style.display = 'none';
        }
    </script>
</body>
</html>

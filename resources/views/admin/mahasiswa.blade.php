<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Mahasiswa - Admin Clazzy</title>
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
		
		.tabs { background: white; padding: 0 2rem; display: flex; gap: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
		.tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
		.tab:hover { color: #9333ea; }
		.tab.active { color: #9333ea; border-bottom-color: #9333ea; }

		.container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
		.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
		.page-title { font-size: 1.8rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; }
		.page-title i { color: #9333ea; }

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

		.empty { text-align: center; padding: 4rem; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); color: #999; }
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
		<a href="{{ route('admin.jurnal-rps') }}" class="tab"><i class="fas fa-journal-whills"></i> Jurnal & RPS</a>
		<a href="{{ route('admin.mahasiswa') }}" class="tab active"><i class="fas fa-user-friends"></i> Daftar Mahasiswa</a>
		<a href="{{ route('admin.pengumuman') }}" class="tab"><i class="fas fa-bullhorn"></i> Pengumuman</a>
	</div>

	<div class="container">
		<div class="page-header">
			<div class="page-title"><i class="fas fa-user-friends"></i> Daftar Seluruh Mahasiswa</div>
		</div>

		@if($mahasiswa->isEmpty())
			<div class="empty">
				<i class="fas fa-users-slash"></i>
				<p>Belum ada mahasiswa terdaftar di sistem.</p>
			</div>
		@else
			<div class="card-table">
				<table>
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Mahasiswa</th>
							<th>Email</th>
							<th>Mata Kuliah Terdaftar & Nilai Akhir</th>
						</tr>
					</thead>
					<tbody>
						@foreach($mahasiswa as $i => $m)
							<tr>
								<td>{{ $i + 1 }}</td>
								<td><strong>{{ $m->name }}</strong></td>
								<td>{{ $m->email }}</td>
								<td>
									@if($m->nilai_details->isEmpty())
										<span style="color:#aaa; font-style:italic;">Belum mengambil mata kuliah</span>
									@else
										<div style="display:flex; flex-direction:column; gap:0.4rem;">
											@foreach($m->nilai_details as $score)
												<div style="display:flex; align-items:center; gap:0.5rem;">
													<span class="badge badge-blue">{{ $score->mata_kuliah }}</span>
													<span style="font-size:0.9rem;">
														Nilai: <strong>{{ number_format($score->total_nilai ?? 0, 2) }}</strong>
													</span>
													@if($score->akreditasi)
														<span class="badge badge-purple" style="padding: 0.1rem 0.5rem; font-size: 0.75rem;">
															Grade: {{ $score->akreditasi }}
														</span>
													@endif
												</div>
											@endforeach
										</div>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
	</div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Mahasiswa - Clazzy</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; color: #333; }
		.navbar { background: #e0e0e0; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
		.logo { display: flex; align-items: center; gap: 0.5rem; font-size: 1.8rem; font-weight: bold; text-decoration: none; color: #333; }
		.logo-icon { background: linear-gradient(135deg, #0891b2, #06b6d4); color: white; width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
		.nav-right { display: flex; align-items: center; gap: 1rem; }
		.btn { padding: 0.6rem 1.5rem; border: 2px solid #00bcd4; border-radius: 8px; background: white; color: #00bcd4; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
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

		.filter-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 2rem; }
		.form-group { display: flex; flex-direction: column; gap: 0.5rem; max-width: 400px; }
		label { font-weight: 600; color: #4b5563; font-size: 0.9rem; }
		select { padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }

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
		<a href="{{ route('dosen.nilai') }}" class="tab"><i class="fas fa-edit"></i> Input Nilai</a>
		<a href="{{ route('dosen.jurnal-rps') }}" class="tab"><i class="fas fa-journal-whills"></i> Jurnal & RPS</a>
		<a href="{{ route('dosen.mahasiswa') }}" class="tab active"><i class="fas fa-user-friends"></i> Daftar Mahasiswa</a>
	</div>

	<div class="container">
		<div class="page-header">
			<div class="page-title"><i class="fas fa-user-friends"></i> Daftar Mahasiswa Terdaftar</div>
		</div>

		<div class="filter-card">
			<form action="{{ route('dosen.mahasiswa') }}" method="GET" id="filter-form">
				<div class="form-group">
					<label for="mata_kuliah">Filter berdasarkan Kelas / Mata Kuliah</label>
					<select name="mata_kuliah" id="mata_kuliah" onchange="document.getElementById('filter-form').submit();">
						<option value="">-- Tampilkan Semua Mahasiswa --</option>
						@foreach($myCourses as $mc)
							<option value="{{ $mc->nama }}" {{ $selectedCourse === $mc->nama ? 'selected' : '' }}>
								{{ $mc->nama }} ({{ $mc->kode }})
							</option>
						@endforeach
					</select>
				</div>
			</form>
		</div>

		@if($mahasiswa->isEmpty())
			<div class="empty">
				<i class="fas fa-users-slash"></i>
				<p>Tidak ada mahasiswa ditemukan untuk filter ini.</p>
			</div>
		@else
			<div class="card-table">
				<table>
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Lengkap</th>
							<th>Alamat Email</th>
							@if($selectedCourse)
								<th style="text-align: center;">Presensi (20%)</th>
								<th style="text-align: center;">Tugas & Keaktifan (20%)</th>
								<th style="text-align: center;">UTS (25%)</th>
								<th style="text-align: center;">UAS (35%)</th>
								<th style="text-align: center;">Total Nilai</th>
								<th style="text-align: center;">Grade</th>
							@else
								<th>Mata Kuliah Terdaftar (Pengampu Anda)</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@foreach($mahasiswa as $i => $m)
							<tr>
								<td>{{ $i + 1 }}</td>
								<td><strong>{{ $m->name }}</strong></td>
								<td>{{ $m->email }}</td>
								@if($selectedCourse)
									@php
										$score = $m->nilai_details->where('mata_kuliah', $selectedCourse)->first();
									@endphp
									<td style="text-align: center;">{{ $score && $score->nilai_presensi !== null ? number_format($score->nilai_presensi, 1) : '-' }}</td>
									<td style="text-align: center;">{{ $score && $score->nilai_tugas !== null ? number_format($score->nilai_tugas, 1) : '-' }}</td>
									<td style="text-align: center;">{{ $score && $score->nilai_uts !== null ? number_format($score->nilai_uts, 1) : '-' }}</td>
									<td style="text-align: center;">{{ $score && $score->nilai_uas !== null ? number_format($score->nilai_uas, 1) : '-' }}</td>
									<td style="text-align: center;">
										<strong style="color: #9333ea;">
											{{ $score && $score->total_nilai !== null ? number_format($score->total_nilai, 2) : '-' }}
										</strong>
									</td>
									<td style="text-align: center;">
										@if($score && $score->akreditasi)
											<span class="badge badge-purple">{{ $score->akreditasi }}</span>
										@else
											-
										@endif
									</td>
								@else
									<td>
										@if($m->nilai_details->isEmpty())
											<span style="color:#999; font-style:italic;">Belum terdaftar di kelas Anda</span>
										@else
											<div style="display:flex; flex-wrap:wrap; gap:0.4rem;">
												@foreach($m->nilai_details as $score)
													<span class="badge badge-blue">{{ $score->mata_kuliah }}</span>
												@endforeach
											</div>
										@endif
									</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
	</div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pemantauan Jurnal & RPS - Admin Clazzy</title>
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

		.filter-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 2rem; }
		.form-group { display: flex; flex-direction: column; gap: 0.5rem; max-width: 400px; }
		label { font-weight: 600; color: #4b5563; font-size: 0.9rem; }
		select { padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }

		.flex-container { display: flex; gap: 2rem; align-items: flex-start; }
		.section-half { flex: 1; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 1.5rem; }
		
		h3 { margin-bottom: 1rem; font-size: 1.25rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
		h3 i { color: #0891b2; }

		.card-table { border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; }
		table { width: 100%; border-collapse: collapse; }
		thead { background: #f3f4f6; color: #374151; border-bottom: 1px solid #e5e7eb; }
		th { padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; }
		td { padding: 0.75rem 1rem; border-bottom: 1px solid #f3f4f6; vertical-align: middle; font-size: 0.9rem; }
		tr:last-child td { border-bottom: none; }
		tr:hover td { background: #fafafa; }

		.badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
		.badge-purple { background: #ede9fe; color: #7c3aed; }
		.badge-blue { background: #e0f2fe; color: #0369a1; }
		
		.status-badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
		.status-terlaksana { background: #dcfce7; color: #16a34a; }
		.status-batal { background: #fee2e2; color: #991b1b; }
		.status-tunda { background: #f3f4f6; color: #4b5563; }

		@media (max-width: 768px) {
			.flex-container { flex-direction: column; }
			.section-half { width: 100%; }
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
		<a href="{{ route('admin.jurnal-rps') }}" class="tab active"><i class="fas fa-journal-whills"></i> Jurnal & RPS</a>
		<a href="{{ route('admin.mahasiswa') }}" class="tab"><i class="fas fa-user-friends"></i> Daftar Mahasiswa</a>
		<a href="{{ route('admin.pengumuman') }}" class="tab"><i class="fas fa-bullhorn"></i> Pengumuman</a>
	</div>

	<div class="container">
		<div class="page-header">
			<div class="page-title"><i class="fas fa-journal-whills"></i> Pemantauan Jurnal Realisasi & RPS Kuliah</div>
		</div>

		<div class="filter-card">
			<div class="form-group">
				<label for="course-monitor">Pilih Mata Kuliah untuk Dipantau</label>
				<select id="course-monitor" onchange="loadCourseData()">
					<option value="" disabled selected>-- Pilih Mata Kuliah --</option>
					@foreach($mataKuliah as $mk)
						<option value="{{ $mk->nama }}">{{ $mk->nama }} (Dosen: {{ $mk->dosen }})</option>
					@endforeach
				</select>
			</div>
		</div>

		<div id="monitor-panels" class="flex-container" style="display: none;">
			<!-- RPS Panel -->
			<div class="section-half">
				<h3><i class="fas fa-scroll"></i> Rencana Pembelajaran (RPS)</h3>
				<div class="card-table">
					<table>
						<thead>
							<tr>
								<th style="width: 60px;">Pertemuan</th>
								<th>Topik Rencana</th>
							</tr>
						</thead>
						<tbody id="rps-rows">
							<!-- JS populated -->
						</tbody>
					</table>
				</div>
			</div>

			<!-- Jurnal Panel -->
			<div class="section-half">
				<h3><i class="fas fa-calendar-check"></i> Jurnal Realisasi Kuliah</h3>
				<div class="card-table">
					<table>
						<thead>
							<tr>
								<th style="width: 60px;">P-</th>
								<th>Materi Terlaksana</th>
								<th>Tanggal</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="jurnal-rows">
							<!-- JS populated -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<script>
		const rpsData = {!! json_encode($rpsList) !!};
		const jurnalData = {!! json_encode($jurnalList) !!};

		function loadCourseData() {
			const selectedCourse = document.getElementById('course-monitor').value;
			if (!selectedCourse) return;

			document.getElementById('monitor-panels').style.display = 'flex';

			renderRps(selectedCourse);
			renderJurnal(selectedCourse);
		}

		function renderRps(course) {
			const tbody = document.getElementById('rps-rows');
			tbody.innerHTML = '';
			const filteredRps = rpsData.filter(r => r.mata_kuliah === course).sort((a,b) => a.pertemuan - b.pertemuan);

			for(let i = 1; i <= 16; i++) {
				const item = filteredRps.find(r => r.pertemuan === i);
				const tr = document.createElement('tr');
				tr.innerHTML = `
					<td><span class="badge badge-purple">${i}</span></td>
					<td>
						<strong>${item ? item.topik : '<span style="color:#aaa; font-style:italic;">Belum direncanakan</span>'}</strong>
						${item && item.aktivitas ? `<div style="font-size:0.8rem; color:#6b7280; margin-top:0.25rem;">Aktivitas: ${item.aktivitas}</div>` : ''}
					</td>
				`;
				tbody.appendChild(tr);
			}
		}

		function renderJurnal(course) {
			const tbody = document.getElementById('jurnal-rows');
			tbody.innerHTML = '';
			const filteredJurnal = jurnalData.filter(j => j.mata_kuliah === course).sort((a,b) => a.pertemuan - b.pertemuan);

			for(let i = 1; i <= 16; i++) {
				const item = filteredJurnal.find(j => j.pertemuan === i);
				let dateStr = '-';
				if (item && item.tanggal) {
					const d = new Date(item.tanggal);
					dateStr = d.toLocaleDateString('id-ID', {day: 'numeric', month: 'short'});
				}

				let statusHtml = '<span class="status-badge status-tunda">Tunda</span>';
				if (item) {
					statusHtml = `<span class="status-badge status-${item.status}">${item.status}</span>`;
				}

				const tr = document.createElement('tr');
				tr.innerHTML = `
					<td><span class="badge badge-blue">${i}</span></td>
					<td>
						<strong>${item && item.materi_realisasi ? item.materi_realisasi : '<span style="color:#aaa; font-style:italic;">Belum ada realisasi</span>'}</strong>
						${item && item.catatan ? `<div style="font-size:0.8rem; color:#4b5563; margin-top:0.25rem; font-style:italic;">Catatan: "${item.catatan}"</div>` : ''}
						${item && item.dosen ? `<div style="font-size:0.75rem; color:#9c27b0; margin-top:0.15rem;">Oleh: ${item.dosen.name}</div>` : ''}
					</td>
					<td>${dateStr}</td>
					<td>${statusHtml}</td>
				`;
				tbody.appendChild(tr);
			}
		}
	</script>
</body>
</html>

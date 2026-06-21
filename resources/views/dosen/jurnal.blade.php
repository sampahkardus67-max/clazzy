<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Jurnal & RPS - Clazzy</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
		.btn-add { background: #9333ea; color: white; border-color: #9333ea; }
		.btn-add:hover { background: #7e22ce; border-color: #7e22ce; }
		.btn-excel { background: #22c55e; color: white; border-color: #22c55e; }
		.btn-excel:hover { background: #16a34a; border-color: #16a34a; }

		.tabs { background: white; padding: 0 2rem; display: flex; gap: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
		.tab { padding: 1rem 1.5rem; text-decoration: none; color: #666; font-weight: 500; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
		.tab:hover { color: #9333ea; }
		.tab.active { color: #9333ea; border-bottom-color: #9333ea; }

		.sub-tabs { display: flex; gap: 0; margin-bottom: 1.5rem; background: white; border-radius: 12px; padding: 0.4rem; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: fit-content; }
		.sub-tab { padding: 0.6rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; border: none; background: transparent; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; }
		.sub-tab.active { background: #9333ea; color: white; }
		.sub-tab:hover:not(.active) { background: #f3e8ff; color: #9333ea; }
		
		.tab-panel { display: none; }
		.tab-panel.active { display: block; }

		.container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
		.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
		.page-title { font-size: 1.8rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; }
		.page-title i { color: #9333ea; }

		.filter-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 2rem; }
		.form-group { display: flex; flex-direction: column; gap: 0.5rem; }
		label { font-weight: 600; color: #4b5563; font-size: 0.9rem; }
		select, input[type="text"], input[type="date"], textarea { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; }
		textarea { resize: vertical; min-height: 80px; }

		.flex-container { display: flex; gap: 2rem; align-items: flex-start; }
		.form-section { flex: 1.2; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 2rem; }
		.list-section { flex: 2; }

		.card-table { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
		table { width: 100%; border-collapse: collapse; }
		thead { background: linear-gradient(135deg, #0891b2, #06b6d4); color: white; }
		th { padding: 1rem 1.5rem; text-align: left; font-weight: 600; }
		td { padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
		tr:last-child td { border-bottom: none; }
		tr:hover td { background: #f0fdfa; }

		.status-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
		.status-terlaksana { background: #dcfce7; color: #16a34a; }
		.status-batal { background: #fee2e2; color: #991b1b; }
		.status-tunda { background: #f3f4f6; color: #4b5563; }

		.alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #4caf50; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
		.empty { text-align: center; padding: 4rem; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); color: #999; }
		.empty i { font-size: 3rem; margin-bottom: 1rem; display: block; }

		/* Excel Modal Styling */
		.modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
		.modal-content { background: white; padding: 2rem; border-radius: 12px; max-width: 600px; width: 90%; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
		.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
		.modal-header h3 { font-size: 1.3rem; }
		.close-btn { font-size: 1.5rem; cursor: pointer; border: none; background: transparent; }

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
		<a href="{{ route('dosen.tugas') }}" class="tab"><i class="fas fa-tasks"></i> Tugas Baru</a>
		<a href="{{ route('dosen.nilai') }}" class="tab"><i class="fas fa-edit"></i> Input Nilai</a>
		<a href="{{ route('dosen.jurnal-rps') }}" class="tab active"><i class="fas fa-journal-whills"></i> Jurnal & RPS</a>
		<a href="{{ route('dosen.mahasiswa') }}" class="tab"><i class="fas fa-user-friends"></i> Daftar Mahasiswa</a>
	</div>

	<div class="container">
		<div class="page-header">
			<div class="page-title"><i class="fas fa-journal-whills"></i> Rencana Pembelajaran (RPS) & Jurnal Kuliah</div>
		</div>

		@if(session('success'))
			<div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
		@endif

		{{-- Selection Card --}}
		<div class="filter-card">
			<div class="form-group" style="max-width: 400px;">
				<label for="course-selector">Pilih Mata Kuliah</label>
				<select id="course-selector" onchange="switchCourse()">
					<option value="" disabled selected>-- Pilih Mata Kuliah --</option>
					@foreach($myCourses as $mc)
						<option value="{{ $mc->nama }}">{{ $mc->nama }} ({{ $mc->kode }})</option>
					@endforeach
				</select>
			</div>
		</div>

		<div id="main-content" style="display: none;">
			{{-- Sub tabs --}}
			<div class="sub-tabs">
				<button class="sub-tab active" onclick="switchPanel('rps')"><i class="fas fa-scroll"></i> RPS (Rencana Pembelajaran)</button>
				<button class="sub-tab" onclick="switchPanel('jurnal')"><i class="fas fa-calendar-check"></i> Jurnal Realisasi Kuliah</button>
			</div>

			<!-- ========================================== -->
			<!-- TAB PANEL: RPS -->
			<!-- ========================================== -->
			<div id="panel-rps" class="tab-panel active">
				<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
					<h3><i class="fas fa-scroll"></i> Struktur Rencana Pembelajaran Semester</h3>
					<div>
						<button type="button" class="btn btn-excel btn-action" onclick="openRpsImportModal()">
							<i class="fas fa-file-excel"></i> Impor RPS Excel
						</button>
					</div>
				</div>

				<div class="card-table">
					<table>
						<thead>
							<tr>
								<th style="width: 80px;">Pertemuan</th>
								<th>Topik Bahasan</th>
								<th>Rencana Aktivitas / Metode</th>
							</tr>
						</thead>
						<tbody id="rps-table-body">
							<!-- Populated via JS -->
						</tbody>
					</table>
				</div>
			</div>

			<!-- ========================================== -->
			<!-- TAB PANEL: JURNAL KULIAH -->
			<!-- ========================================== -->
			<div id="panel-jurnal" class="tab-panel">
				<div class="flex-container">
					<!-- Jurnal List -->
					<div class="list-section">
						<h3><i class="fas fa-clipboard-list"></i> Realisasi Pertemuan 1 - 16</h3>
						<div class="card-table">
							<table>
								<thead>
									<tr>
										<th>P-</th>
										<th>Rencana Topik</th>
										<th>Tanggal</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody id="jurnal-table-body">
									<!-- Populated via JS -->
								</tbody>
							</table>
						</div>
					</div>

					<!-- Jurnal Editor Form -->
					<div class="form-section">
						<h3 id="form-jurnal-title"><i class="fas fa-pen-alt"></i> Pengisian Jurnal Kuliah</h3>
						<form action="{{ route('dosen.jurnal.store') }}" method="POST">
							@csrf
							<input type="hidden" name="mata_kuliah" id="form-jurnal-course">
							<input type="hidden" name="pertemuan" id="form-jurnal-meeting">

							<div class="form-group" style="margin-bottom: 1rem;">
								<label>Pertemuan Ke-</label>
								<input type="text" id="form-jurnal-meeting-label" disabled style="background:#fafafa;">
							</div>

							<div class="form-group" style="margin-bottom: 1rem;">
								<label for="jurnal-tanggal">Tanggal Pelaksanaan</label>
								<input type="date" name="tanggal" id="jurnal-tanggal" required>
							</div>

							<div class="form-group" style="margin-bottom: 1rem;">
								<label for="jurnal-materi">Materi Realisasi</label>
								<textarea name="materi_realisasi" id="jurnal-materi" placeholder="Materi yang diajarkan..." required></textarea>
							</div>

							<div class="form-group" style="margin-bottom: 1rem;">
								<label for="jurnal-catatan">Catatan / Keterangan Kuliah</label>
								<textarea name="catatan" id="jurnal-catatan" placeholder="Catatan kelas, misal: berjalan lancar, kendala teknis..."></textarea>
							</div>

							<div class="form-group" style="margin-bottom: 1.5rem;">
								<label for="jurnal-status">Status Pembelajaran</label>
								<select name="status" id="jurnal-status" required>
									<option value="terlaksana">Terlaksana</option>
									<option value="batal">Batal</option>
									<option value="tunda">Tunda</option>
								</select>
							</div>

							<button type="submit" class="btn btn-add" style="width: 100%; justify-content: center;">
								<i class="fas fa-save"></i> Simpan Jurnal Kuliah
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ========================================== -->
	<!-- MODAL IMPOR RPS EXCEL -->
	<!-- ========================================== -->
	<div id="import-modal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h3><i class="fas fa-file-excel"></i> Impor RPS Semester</h3>
				<button type="button" class="close-btn" onclick="closeRpsImportModal()">&times;</button>
			</div>
			
			<div style="margin-bottom: 1.5rem; padding: 1rem; background: #f0fdfa; border-left: 4px solid #22c55e; border-radius: 4px; font-size: 0.85rem; line-height: 1.5;">
				<strong>Format File Excel:</strong><br>
				Format file harus memiliki kolom header persis berikut:<br>
				<code>Pertemuan</code> (angka 1-16) | <code>Topik</code> (judul materi) | <code>Aktivitas</code> (rencana pembelajaran)<br>
				<a href="#" onclick="downloadRpsTemplate(); return false;" style="color:#0369a1; text-decoration:underline; font-weight:bold; display:block; margin-top:0.5rem;">Unduh Template RPS (.xlsx)</a>
			</div>

			<div class="form-group" style="margin-bottom: 1.5rem;">
				<label for="rps-file-input">Pilih File Excel/CSV (.xlsx, .xls, .csv)</label>
				<input type="file" id="rps-file-input" accept=".xlsx, .xls, .csv" onchange="handleRpsFile(event)">
			</div>

			<div id="import-preview-section" style="display:none; max-height:200px; overflow-y:auto; margin-bottom:1.5rem; border:1px solid #e5e7eb; border-radius:8px;">
				<table style="font-size:0.85rem;">
					<thead style="background:#f3f4f6; color:#374151;">
						<tr>
							<th style="padding:0.5rem;">Pertemuan</th>
							<th style="padding:0.5rem;">Topik</th>
							<th style="padding:0.5rem;">Aktivitas</th>
						</tr>
					</thead>
					<tbody id="import-preview-rows">
						<!-- Preview rows -->
					</tbody>
				</table>
			</div>

			<form id="import-rps-form" action="{{ route('dosen.rps.import') }}" method="POST">
				@csrf
				<input type="hidden" name="mata_kuliah" id="import-rps-course">
				<input type="hidden" name="rps_data" id="import-rps-payload">
				
				<button type="submit" id="submit-import-btn" class="btn btn-add" style="width: 100%; justify-content: center;" disabled>
					<i class="fas fa-upload"></i> Simpan & Terapkan RPS
				</button>
			</form>
		</div>
	</div>

	<script>
		// Raw JSON data passed from Laravel
		const rawRps = {!! json_encode($rpsList) !!};
		const rawJurnal = {!! json_encode($jurnalList) !!};

		function switchCourse() {
			const selectedCourse = document.getElementById('course-selector').value;
			if (!selectedCourse) return;

			document.getElementById('main-content').style.display = 'block';
			document.getElementById('form-jurnal-course').value = selectedCourse;
			document.getElementById('import-rps-course').value = selectedCourse;

			renderRpsTable(selectedCourse);
			renderJurnalTable(selectedCourse);
			selectMeeting(selectedCourse, 1); // Default to select meeting 1 in form
		}

		function switchPanel(panelName) {
			document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
			document.querySelectorAll('.sub-tab').forEach(t => t.classList.remove('active'));
			document.getElementById('panel-' + panelName).classList.add('active');
			event.currentTarget.classList.add('active');
		}

		function renderRpsTable(course) {
			const container = document.getElementById('rps-table-body');
			container.innerHTML = '';
			const courseRps = rawRps.filter(r => r.mata_kuliah === course).sort((a,b) => a.pertemuan - b.pertemuan);

			for(let i = 1; i <= 16; i++) {
				const rpsItem = courseRps.find(r => r.pertemuan === i);
				const row = document.createElement('tr');
				row.innerHTML = `
					<td><span class="badge badge-purple" style="font-size:0.9rem;">${i}</span></td>
					<td><strong>${rpsItem ? rpsItem.topik : '<span style="color:#aaa; font-style:italic;">Belum direncanakan</span>'}</strong></td>
					<td>${rpsItem && rpsItem.aktivitas ? rpsItem.aktivitas : '-'}</td>
				`;
				container.appendChild(row);
			}
		}

		function renderJurnalTable(course) {
			const container = document.getElementById('jurnal-table-body');
			container.innerHTML = '';
			const courseRps = rawRps.filter(r => r.mata_kuliah === course);
			const courseJurnal = rawJurnal.filter(j => j.mata_kuliah === course);

			for(let i = 1; i <= 16; i++) {
				const rpsItem = courseRps.find(r => r.pertemuan === i);
				const jurnalItem = courseJurnal.find(j => j.pertemuan === i);

				let dateStr = '-';
				if (jurnalItem && jurnalItem.tanggal) {
					const d = new Date(jurnalItem.tanggal);
					dateStr = d.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
				}

				let statusHtml = '<span class="status-badge status-tunda">Tunda / Belum</span>';
				if (jurnalItem) {
					statusHtml = `<span class="status-badge status-${jurnalItem.status}">${jurnalItem.status.charAt(0).toUpperCase() + jurnalItem.status.slice(1)}</span>`;
				}

				const row = document.createElement('tr');
				row.innerHTML = `
					<td><span class="badge badge-blue">${i}</span></td>
					<td>
						<span style="font-size:0.8rem; color:#6b7280; display:block;">Rencana RPS:</span>
						<strong>${rpsItem ? rpsItem.topik : '(Tidak ada rencana)'}</strong>
						${jurnalItem && jurnalItem.materi_realisasi ? `<span style="font-size:0.8rem; display:block; color:#0369a1; margin-top:0.25rem;">Realisasi: ${jurnalItem.materi_realisasi}</span>` : ''}
					</td>
					<td>${dateStr}</td>
					<td>${statusHtml}</td>
					<td>
						<button type="button" class="btn btn-action btn-edit" onclick="selectMeeting('${course}', ${i})">
							Isi Jurnal
						</button>
					</td>
				`;
				container.appendChild(row);
			}
		}

		function selectMeeting(course, meetingNum) {
			document.getElementById('form-jurnal-meeting').value = meetingNum;
			document.getElementById('form-jurnal-meeting-label').value = 'Pertemuan ' + meetingNum;

			const courseRps = rawRps.filter(r => r.mata_kuliah === course);
			const courseJurnal = rawJurnal.filter(j => j.mata_kuliah === course);

			const rpsItem = courseRps.find(r => r.pertemuan === meetingNum);
			const jurnalItem = courseJurnal.find(j => j.pertemuan === meetingNum);

			if (jurnalItem) {
				document.getElementById('jurnal-tanggal').value = jurnalItem.tanggal || '';
				document.getElementById('jurnal-materi').value = jurnalItem.materi_realisasi || '';
				document.getElementById('jurnal-catatan').value = jurnalItem.catatan || '';
				document.getElementById('jurnal-status').value = jurnalItem.status || 'terlaksana';
			} else {
				// Default values for new entry
				document.getElementById('jurnal-tanggal').value = new Date().toISOString().split('T')[0];
				document.getElementById('jurnal-materi').value = rpsItem ? rpsItem.topik : '';
				document.getElementById('jurnal-catatan').value = '';
				document.getElementById('jurnal-status').value = 'terlaksana';
			}
		}

		// Excel Modal & Parser Functions
		function openRpsImportModal() {
			document.getElementById('import-modal').style.display = 'flex';
			document.getElementById('rps-file-input').value = '';
			document.getElementById('import-preview-section').style.display = 'none';
			document.getElementById('submit-import-btn').disabled = true;
		}

		function closeRpsImportModal() {
			document.getElementById('import-modal').style.display = 'none';
		}

		function handleRpsFile(e) {
			const file = e.target.files[0];
			if (!file) return;

			const reader = new FileReader();
			reader.onload = function(evt) {
				const data = evt.target.result;
				const workbook = XLSX.read(data, { type: 'binary' });
				const firstSheetName = workbook.SheetNames[0];
				const worksheet = workbook.Sheets[firstSheetName];
				const json = XLSX.utils.sheet_to_json(worksheet);

				// Render Preview
				const previewBody = document.getElementById('import-preview-rows');
				previewBody.innerHTML = '';

				if (json.length === 0) {
					alert("File Excel kosong atau format tidak sesuai.");
					return;
				}

				json.forEach(row => {
					const pert = row.Pertemuan || row.pertemuan || '';
					const top = row.Topik || row.topik || '';
					const akt = row.Aktivitas || row.aktivitas || '';

					const tr = document.createElement('tr');
					tr.innerHTML = `
						<td style="padding:0.4rem; border-bottom:1px solid #eee;">${pert}</td>
						<td style="padding:0.4rem; border-bottom:1px solid #eee;">${top}</td>
						<td style="padding:0.4rem; border-bottom:1px solid #eee;">${akt}</td>
					`;
					previewBody.appendChild(tr);
				});

				document.getElementById('import-preview-section').style.display = 'block';
				document.getElementById('import-rps-payload').value = JSON.stringify(json);
				document.getElementById('submit-import-btn').disabled = false;
			};
			reader.readAsBinaryString(file);
		}

		function downloadRpsTemplate() {
			const data = [
				["Pertemuan", "Topik", "Aktivitas"],
				[1, "Pengenalan Algoritma", "Kuliah & Diskusi"],
				[2, "Tipe Data & Variabel", "Praktikum Mandiri"],
				[3, "Struktur Kontrol Kondisi", "Kuliah Teori & Tanya Jawab"]
			];
			const ws = XLSX.utils.aoa_to_sheet(data);
			const wb = XLSX.utils.book_new();
			XLSX.utils.book_append_sheet(wb, ws, "Template RPS");
			XLSX.writeFile(wb, "template_rps.xlsx");
		}
	</script>
</body>
</html>

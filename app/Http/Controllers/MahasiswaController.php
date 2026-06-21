<?php
namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Tugas;
use App\Models\Nilai;
use Illuminate\Http\Request;
use App\Models\TugasDosen;
use App\Models\Materi;

class MahasiswaController extends Controller
{
    public function mataKuliah() {
        $mataKuliah = MataKuliah::all();
        return view('mahasiswa.mata-kuliah', compact('mataKuliah'));
    }

public function tugas()
{
    $tugas = Tugas::where('user_id', auth()->id())->get();
    $tugasDosen = TugasDosen::orderBy('deadline', 'asc')->get();
    return view('mahasiswa.tugas', compact('tugas', 'tugasDosen'));
}

    public function nilai() {
        $nilai = Nilai::all();
        return view('mahasiswa.nilai', compact('nilai'));
    }

    public function uploadTugas(Request $request) {
        $request->validate(['file' => 'required|file|max:10240']);
        $path = $request->file('file')->store('tugas', 'public');
        Tugas::create([
            'nama' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]);
        return back()->with('success', 'Tugas berhasil dikirim!');
    }

    public function downloadTugas($id) {
        $tugas = Tugas::findOrFail($id);
        return response()->download(storage_path('app/public/' . $tugas->file_path));
    }

    public function materi() {
        $materiList = Materi::orderBy('pertemuan', 'asc')->get();
        return view('mahasiswa.materi', compact('materiList'));
    }

    public function downloadMateri($id) {
        $materi = Materi::findOrFail($id);
        return response()->download(storage_path('app/public/' . $materi->file_path));
    }
}
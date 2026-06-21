<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@clazzy.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Seed Lecturers (Dosen)
        User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Kom',
            'email' => 'ahmad.fauzi@clazzy.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Dr. Siti Rahayu, M.T',
            'email' => 'siti.rahayu@clazzy.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Budi Santoso, S.Kom, M.Cs',
            'email' => 'budi.santoso@clazzy.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'dosen',
        ]);

        // Seed Students (Mahasiswa)
        $mhs = User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky.pratama@mhs.clazzy.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Seed Mata Kuliah
        \DB::table('mata_kuliah')->insert([
            ['nama' => 'Algoritma dan Pemrograman', 'kode' => 'IF101', 'sks' => 3, 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pemrograman Web', 'kode' => 'IF201', 'sks' => 3, 'dosen' => 'Dr. Ahmad Fauzi, M.Kom', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Basis Data', 'kode' => 'SI101', 'sks' => 3, 'dosen' => 'Budi Santoso, S.Kom, M.Cs', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Jaringan Komputer', 'kode' => 'IF301', 'sks' => 3, 'dosen' => 'Dr. Siti Rahayu, M.T', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed Tugas Dosen
        \DB::table('tugas_dosen')->insert([
            [
                'judul' => 'Tugas 1: Algoritma Sorting',
                'penjelasan' => 'Implementasikan algoritma Bubble Sort, Quick Sort, dan Merge Sort dalam Python. Bandingkan kompleksitas waktu masing-masing.',
                'mata_kuliah' => 'Algoritma dan Pemrograman',
                'deadline' => now()->addDays(7),
                'file_path' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Tugas 1: HTML dan CSS Dasar',
                'penjelasan' => 'Buat halaman web profil pribadi menggunakan HTML5 dan CSS3. Terapkan prinsip responsive design.',
                'mata_kuliah' => 'Pemrograman Web',
                'deadline' => now()->addDays(5),
                'file_path' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Seed Nilai
        \DB::table('nilai')->insert([
            ['user_id' => $mhs->id, 'mata_kuliah' => 'Algoritma dan Pemrograman', 'nilai' => 85.00, 'grade' => 'A', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $mhs->id, 'mata_kuliah' => 'Pemrograman Web', 'nilai' => 90.00, 'grade' => 'A', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tugas')->insert([
            [
                'idStaffUnit' => 6,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Input Data Mahasiswa',
                'deskripsi' => 'Melakukan input data mahasiswa ke sistem',
                'bobotNilai' => 20,
                'tenggatPengumpulan' => '2026-05-01',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 6,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Rekap Absensi',
                'deskripsi' => 'Merekap data absensi harian',
                'bobotNilai' => 20,
                'tenggatPengumpulan' => '2026-05-02',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 6,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Validasi Data',
                'deskripsi' => 'Memvalidasi data pendaftar',
                'bobotNilai' => 25,
                'tenggatPengumpulan' => '2026-05-03',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 7,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Input Excel',
                'deskripsi' => 'Memasukkan data ke excel',
                'bobotNilai' => 15,
                'tenggatPengumpulan' => '2026-05-04',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 7,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Update Database',
                'deskripsi' => 'Update data pada database',
                'bobotNilai' => 20,
                'tenggatPengumpulan' => '2026-05-05',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 14,
                'idUnit' => 5,
                'idLowongan' => 7,
                'namaTugas' => 'Rekap Kehadiran Kegiatan Mahasiswa',
                'deskripsi' => 'Melakukan rekap data kehadiran kegiatan mahasiswa',
                'bobotNilai' => 20,
                'tenggatPengumpulan' => '2026-05-10',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 14,
                'idUnit' => 5,
                'idLowongan' => 7,
                'namaTugas' => 'Membuat Dokumentasi Kegiatan',
                'deskripsi' => 'Menyusun dokumentasi kegiatan mahasiswa',
                'bobotNilai' => 20,
                'tenggatPengumpulan' => '2026-05-12',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 15,
                'idUnit' => 5,
                'idLowongan' => 7,
                'namaTugas' => 'Input Data Organisasi Mahasiswa',
                'deskripsi' => 'Melakukan input dan pengecekan data organisasi mahasiswa',
                'bobotNilai' => 20,
                'tenggatPengumpulan' => '2026-05-14',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 15,
                'idUnit' => 5,
                'idLowongan' => 7,
                'namaTugas' => 'Membantu Persiapan Seminar',
                'deskripsi' => 'Membantu persiapan administrasi seminar mahasiswa',
                'bobotNilai' => 15,
                'tenggatPengumpulan' => '2026-05-16',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 15,
                'idUnit' => 5,
                'idLowongan' => 7,
                'namaTugas' => 'Laporan Evaluasi Kegiatan',
                'deskripsi' => 'Menyusun laporan evaluasi kegiatan mahasiswa',
                'bobotNilai' => 5,
                'tenggatPengumpulan' => '2026-05-18',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}

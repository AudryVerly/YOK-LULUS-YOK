<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianKinerjaFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penilaian_kinerja_form')->insert([
            [
                'idMahasiswa' => 7,
                'idLowongan' => 7,
                'idStaffUnit' => 14,
                'total_nilai' => 83.33,
                'catatan' => 'Ayo dicoba dulu ya',
                'tanggal_menilai' => '2026-05-06',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 7,
                'idLowongan' => 7,
                'idStaffUnit' => 15,
                'total_nilai' => 80,
                'catatan' => 'Untuk inisiatif membantu teman masih harus dikembangkan dan diperhatikan lagi',
                'tanggal_menilai' => '2026-05-17',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}

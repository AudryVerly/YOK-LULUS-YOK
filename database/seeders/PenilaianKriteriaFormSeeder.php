<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianKriteriaFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('penilaian_kriteria_form')->insert([
            [
                'idPenilaianForm' => 1,
                'idKriteriaKinerja' => 1,
                'nilai' => 100,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPenilaianForm' => 1,
                'idKriteriaKinerja' => 2,
                'nilai' => 80,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPenilaianForm' => 1,
                'idKriteriaKinerja' => 3,
                'nilai' => 70,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPenilaianForm' => 2,
                'idKriteriaKinerja' => 1,
                'nilai' => 80,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPenilaianForm' => 2,
                'idKriteriaKinerja' => 2,
                'nilai' => 85,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPenilaianForm' => 2,
                'idKriteriaKinerja' => 3,
                'nilai' => 75,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}

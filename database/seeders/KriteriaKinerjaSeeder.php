<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria_kinerja')->insert([
            [
                'idKriteria' => 6,
                'idUnit' => 5,
                'nama' => 'Team Work',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idKriteria' => 7,
                'idUnit' => 5,
                'nama' => 'Kreativitas',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idKriteria' => 9,
                'idUnit' => 5,
                'nama' => 'Inisiatif',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}

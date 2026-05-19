<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // superadmin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'SuperAdmin',
                'status' => 1,
            ],
            [
                'name' => 'AdminPPKP',
                'email' => 'adminppkp@ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'adminTUTeknik',
                'email' => 'adminTeknik@ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'adminUBC',
                'email' => 'adminUBC@ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'adminDPK',
                'email' => 'adminDPK@ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'adminPPKMI',
                'email' => 'adminPPKMI@ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'Yusuf Pratama',
                'email' => 'yusuf@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Nabila Sari',
                'email' => 'nabila@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Aldi Ramadhan',
                'email' => 'aldi@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Maya Lestari',
                'email' => 'maya@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Rizky Kurniawan',
                'email' => 'rizky@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Tiara Putri',
                'email' => 'tiara@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Farhan Akbar',
                'email' => 'farhan@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Lina Oktavia',
                'email' => 'lina@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Andika Sapto',
                'email' => 'andika@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Wulan Pertiwi',
                'email' => 'wulan@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Rendy Maulana',
                'email' => 'rendy@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Nisa Amelia',
                'email' => 'nisa@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Bintang Aji',
                'email' => 'bintang@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Dian Kartika',
                'email' => 'dian@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@staff.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Ahmad Fauzan',
                'email' => 's160422127@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 's13023115@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Bima Prakoso',
                'email' => 's15023167@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Cindy Oktavia',
                'email' => 's110422156@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Yoga Saputra',
                'email' => 's180322145@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 's150122187@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Raka Putra',
                'email' => 's180522114@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Nadya Safira',
                'email' => 's130322199@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Ilham Maulana',
                'email' => 's160122121@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Putri Ayunda',
                'email' => 's170422135@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardSuperAdminController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = Carbon::now()->subMonth()->year;

        // buat lihat master data
        $totalUser = DB::table('users')->count();
        $totalUnit = DB::table('unit')->count();
        $totalStaff = DB::table('staffUnit')->count();
        $totalMahasiswa = DB::table('mahasiswa')->count();
        $totalKriteria = DB::table('kriteria')->count();

        $userPerRole = DB::table('users')
            ->select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $unitAktif = DB::table('unit')->where('status', 1)->count();
        $unitNonaktif = DB::table('unit')->where('status', 0)->count();

        $kriteriaAktif = DB::table('kriteria')->where('status', 1)->count();
        $kriteriaNonaktif = DB::table('kriteria')->where('status', 0)->count();

        $mahasiswaAktif = DB::table('mahasiswa')->where('status', 1)->count();
        $mahasiswaNonaktif = DB::table('mahasiswa')->where('status', 0)->count();

        $totalLowongan = DB::table('lowongan')->count();
        $lowonganAktif = DB::table('lowongan')->where('status', 1)->count();
        $lowonganTutup = DB::table('lowongan')->where('status', 0)->count();

        $lowonganBuka = DB::table('lowongan')
            ->where('status', 1)
            ->where('awalPendaftaran', '<=', Carbon::today())
            ->where('batasPendaftaran', '>=', Carbon::today())
            ->count();
        $lowonganBaruBulanIni = DB::table('lowongan')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();
        $lowonganPerUnit = DB::table('lowongan')
            ->join('unit', 'unit.id', '=', 'lowongan.idUnit')
            ->select('unit.name as namaUnit', DB::raw('count(lowongan.id) as total'))
            ->groupBy('unit.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $totalPendaftaran = DB::table('pendaftaran')->count();

        $pendaftaranPerStatus = DB::table('pendaftaran')
            ->select('statusPendaftaran', DB::raw('count(*) as total'))
            ->groupBy('statusPendaftaran')
            ->pluck('total', 'statusPendaftaran');

        $pendaftaranBulanIni = DB::table('pendaftaran')
            ->whereMonth('tanggal_daftar', $bulanIni)
            ->whereYear('tanggal_daftar', $tahunIni)
            ->count();
        $pendaftaranBulanLalu = DB::table('pendaftaran')
            ->whereMonth('tanggal_daftar', $bulanLalu)
            ->whereYear('tanggal_daftar', $tahunLalu)
            ->count();

        $totalDiterima = DB::table('pendaftaran')
            ->where('statusPendaftaran', 'diterima')
            ->count();

        return view('dashboard', compact(
            'totalUser', 'totalUnit', 'totalStaff', 'totalMahasiswa', 'totalKriteria',
            'userPerRole', 'unitAktif', 'unitNonaktif', 'mahasiswaAktif', 'mahasiswaNonaktif',
            'kriteriaAktif', 'kriteriaNonaktif', 'totalLowongan', 'lowonganAktif',
            'lowonganTutup', 'lowonganBuka', 'lowonganBaruBulanIni', 'lowonganPerUnit',
            'totalPendaftaran', 'pendaftaranPerStatus', 'pendaftaranBulanIni', 'pendaftaranBulanLalu',
            'totalDiterima',
        ));

    }
}

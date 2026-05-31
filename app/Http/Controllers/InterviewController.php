<?php

namespace App\Http\Controllers;

use App\Mail\InterviewCandidateMail;
use App\Mail\InterviewInterviewerMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InterviewController extends Controller
{
    public function listLowongan()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        $lowongan = DB::table('lowongan as l')
            ->leftJoin('pendaftaran as p', 'p.idLowongan', '=', 'l.id')
            ->leftJoin('progress_tahapan_kandidat as pt', 'pt.idPendaftaran', '=', 'p.id')
            ->leftJoin('tahap_rekrutmen as tr', 'tr.id', '=', 'pt.idTahapRekrutmen')
            ->select(
                'l.id',
                'l.judulLowongan',
                'l.batasPendaftaran',
                'l.mulaiKerja',
                DB::raw('COUNT(DISTINCT p.id) as totalKandidat')
            )
            ->where('l.idUnit', $idUnit)
            ->where('tr.tipe_tahap', 'Wawancara')
            ->whereIn('pt.status', ['Proses', 'Lulus'])
            ->groupBy(
                'l.id',
                'l.judulLowongan',
                'l.batasPendaftaran',
                'l.mulaiKerja'
            )
            ->get();

        foreach ($lowongan as $item) {

            $totalKandidatAktif = DB::table('pendaftaran')
                ->where('idLowongan', $item->id)
                ->whereIn('statusPendaftaran', ['terdaftar', 'diproses', 'diterima'])
                ->count();

            // kandidat yang sudah masuk tahap wawancara
            $totalWawancara = DB::table('pendaftaran as p')
                ->where('p.idLowongan', $item->id)
                ->whereIn('p.statusPendaftaran', ['diproses', 'diterima'])
                ->whereExists(function ($q) {
                    $q->select(DB::raw(1))
                        ->from('progress_tahapan_kandidat as pt')
                        ->join('tahap_rekrutmen as tr', 'tr.id', '=', 'pt.idTahapRekrutmen')
                        ->whereColumn('pt.idPendaftaran', 'p.id')
                        ->where('tr.tipe_tahap', 'Wawancara');
                })
                ->count();

            // kandidat yang sudah dijadwalkan
            $sudahTerjadwal = DB::table('jadwal_wawancara as j')
                ->join('pendaftaran as p', 'p.id', '=', 'j.idPendaftaran')
                ->where('p.idLowongan', $item->id)
                ->where('j.status', '!=', 'batal')
                ->distinct()
                ->count('j.idPendaftaran');

            $belumTerjadwal = max(0, $totalWawancara - $sudahTerjadwal);

            $belumMasukWawancara = max(
                0,
                $totalKandidatAktif - $totalWawancara
            );

            // 5. Display progress
            $item->totalKandidatAktif = $totalKandidatAktif;
            $item->totalWawancara = $totalWawancara;
            $item->sudahTerjadwal = $sudahTerjadwal;
            $item->belumTerjadwal = $belumTerjadwal;
            $item->belumMasukWawancara = $belumMasukWawancara;

            $item->progressGenerate = $totalWawancara.'/'.$totalKandidatAktif;

            if ($totalKandidatAktif == 0) {

                $item->statusGenerate = 'Tidak Ada Kandidat';

            } elseif ($totalWawancara == 0) {

                $item->statusGenerate = 'Belum Ada Kandidat Wawancara';

            } elseif ($belumMasukWawancara > 0) {

                $item->statusGenerate = 'Masih Seleksi Awal';

            } elseif ($sudahTerjadwal < $totalWawancara) {

                $item->statusGenerate = 'Belum Lengkap';

            } elseif (
                $sudahTerjadwal == $totalWawancara &&
                $belumMasukWawancara == 0 &&
                $totalWawancara > 0
            ) {

                $item->statusGenerate = 'Sudah Generate';

            } else {

                $item->statusGenerate = 'Belum Lengkap';
            }
        }

        return view('setwawancara.listlowonganiview', compact('lowongan'));
    }

    public function showAutoGenerate($idLowongan)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        $lowongan = DB::table('lowongan')->where('id', $idLowongan)->first();
        if (! $lowongan) {
            abort(404, 'Lowongan tidak ditemukan');
        }

        // Kandidat yang sudah masuk tahap wawancara tapi BELUM punya jadwal aktif
        $kandidatBelumJadwal = DB::table('pendaftaran as p')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->join('progress_tahapan_kandidat as pt', 'pt.idPendaftaran', '=', 'p.id')
            ->join('tahap_rekrutmen as tr', 'tr.id', '=', 'pt.idTahapRekrutmen')
            ->select(
                'p.id as idPendaftaran',
                'pt.id as idProgressTahapan',
                'u.name as namaMahasiswa',
                'u.email as emailMahasiswa'
            )
            ->where('p.idLowongan', $idLowongan)
            ->where('tr.tipe_tahap', 'Wawancara')
            ->whereIn('pt.status', ['Proses', 'Lulus'])
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('jadwal_wawancara as j')
                    ->whereColumn('j.idPendaftaran', 'p.id')
                    ->where('j.status', '!=', 'batal');
            })
            ->get();

        // Penilai yang tersedia (staff unit aktif, bukan AdminUnit)
        // Kita ambil semua, admin yang pilih
        $penilai = DB::table('staffunit as s')
            ->join('users as u', 's.idUser', '=', 'u.id')
            ->select('s.id as idStaffUnit', 'u.name as namaPenilai')
            ->where('s.idUnit', $idUnit)
            ->where('s.status', 1)
            ->where('u.role', '!=', 'AdminUnit')
            ->get();

        // Preview slot yang akan di-generate (untuk ditampilkan ke admin)
        $previewSlot = $this->generateSlotPreview($lowongan, $kandidatBelumJadwal->count());

        return view('setwawancara.autogenerate', compact(
            'lowongan',
            'kandidatBelumJadwal',
            'penilai',
            'previewSlot'
        ));
    }

    public function prosesAutoGenerate(Request $request, $idLowongan)
    {
        $request->validate([
            'tim_penilai' => 'required|array|min:1',
            'tim_penilai.*' => 'required|exists:staffunit,id',
            'lokasi' => 'nullable|string|max:255',
            'link_wawancara' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_wawancara' => 'required|date',
        ], [
            'tim_penilai.required' => 'Pilih minimal 1 penilai.',
            'tim_penilai.min' => 'Pilih minimal 1 penilai.',
            'tanggal_wawancara' => 'Tanggal mulai wawancara wajib diisi.',
        ]);

        $lowongan = DB::table('lowongan')->where('id', $idLowongan)->first();
        if (! $lowongan) {
            abort(404);
        }

        // Kandidat belum terjadwal
        $kandidat = DB::table('pendaftaran as p')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->join('progress_tahapan_kandidat as pt', 'pt.idPendaftaran', '=', 'p.id')
            ->join('tahap_rekrutmen as tr', 'tr.id', '=', 'pt.idTahapRekrutmen')
            ->join('unit as un', 'un.id', '=', DB::raw("(SELECT idUnit FROM lowongan WHERE id = $idLowongan LIMIT 1)"))
            ->select(
                'p.id as idPendaftaran',
                'pt.id as idProgressTahapan',
                'u.name as namaMahasiswa',
                'u.email as emailMahasiswa',
                'un.name as namaUnit',
                'un.kontak as kontakUnit',
                'un.emailUnit as emailUnit'
            )
            ->where('p.idLowongan', $idLowongan)
            ->where('tr.tipe_tahap', 'Wawancara')
            ->whereIn('pt.status', ['Proses', 'Lulus'])
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('jadwal_wawancara as j')
                    ->whereColumn('j.idPendaftaran', 'p.id')
                    ->where('j.status', '!=', 'batal');
            })
            ->get();

        if ($kandidat->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada kandidat yang perlu dijadwalkan.',
            ], 422);
        }

        // Generate slot waktu otomatis
        $timPenilai = $request->tim_penilai;
        $lokasi = $request->lokasi;
        $linkWawancara = $request->link_wawancara;
        $keterangan = $request->keterangan ?? '';
        $judulLowongan = $lowongan->judulLowongan;

        $tanggalMulaiUser = Carbon::parse($request->tanggal_wawancara);

        // batas maksimal H-3 sebelum kerja
        $tanggalMax = Carbon::parse($lowongan->mulaiKerja)->subDays(3);

        // kalau user pilih lewat batas → paksa ke max
        if ($tanggalMulaiUser->gt($tanggalMax)) {
            $tanggalMulaiUser = $tanggalMax->copy();
        }

        $existingPenilai = DB::table('wawancara_penilai as w')
            ->join('jadwal_wawancara as j', 'j.id', '=', 'w.idJadwalWawancara')
            ->join('pendaftaran as p', 'p.id', '=', 'j.idPendaftaran')
            ->where('p.idLowongan', $idLowongan)
            ->where('w.status', '!=', 'gagal')
            ->distinct()
            ->pluck('w.idStaffUnit')
            ->sort()
            ->values();

        $newPenilai = collect($request->tim_penilai)
            ->sort()
            ->values();

        if ($existingPenilai->isNotEmpty() && $existingPenilai->diff($newPenilai)->isNotEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tim penilai harus sama dengan yang sudah digunakan di lowongan ini.',
            ], 422);
        }

        // $slots = $this->generateSlotsFromDate($tanggalMulaiUser, $tanggalMax, $kandidat->count());
        $slots = $this->generateSlots($tanggalMulaiUser, $tanggalMax, $kandidat->count());

        if (count($slots) < $kandidat->count()) {
            return response()->json([
                'status' => false,
                'message' => 'Slot tidak cukup sampai H-3 sebelum mulai kerja.',
            ], 422);
        }

        DB::transaction(function () use ($kandidat, $slots, $timPenilai, $lokasi, $linkWawancara, $keterangan, $judulLowongan) {
            foreach ($kandidat as $index => $k) {
                $slot = $slots[$index];

                $idJadwal = DB::table('jadwal_wawancara')->insertGetId([
                    'idProgressTahapan' => $k->idProgressTahapan,
                    'idPendaftaran' => $k->idPendaftaran,
                    'tanggal_wawancara' => $slot['tanggal'],
                    'waktu_mulai' => $slot['mulai'],
                    'waktu_selesai' => $slot['selesai'],
                    'lokasi' => $lokasi,
                    'link_wawancara' => $linkWawancara,
                    'keterangan' => $keterangan,
                    'status' => 'terjadwal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert penilai & kirim email
                foreach ($timPenilai as $penilaiId) {
                    $token = Str::random(40);

                    $idPewawancara = DB::table('wawancara_penilai')->insertGetId([
                        'idJadwalWawancara' => $idJadwal,
                        'idStaffUnit' => $penilaiId,
                        'status' => 'belum',
                        'token' => $token,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $urlTerima = url('/interview/confirm/'.$idPewawancara.'/terima?token='.$token);
                    $urlTolak = url('/interview/confirm/'.$idPewawancara.'/tolak?token='.$token);

                    $staffPenilai = DB::table('staffunit as s')
                        ->join('users as u', 's.idUser', '=', 'u.id')
                        ->where('s.id', $penilaiId)
                        ->select('u.email', 'u.name')
                        ->first();

                    $dataEmailInterviewer = [
                        'namaMahasiswa' => $k->namaMahasiswa,
                        'namaLowongan' => $judulLowongan,
                        'tanggal' => $slot['tanggal'],
                        'mulai' => $slot['mulai'],
                        'selesai' => $slot['selesai'],
                        'lokasi' => $lokasi,
                        'link' => $linkWawancara,
                        'urlTerima' => $urlTerima,
                        'urlTolak' => $urlTolak,
                    ];

                    Mail::to($staffPenilai->email)
                        ->send(new InterviewInterviewerMail($dataEmailInterviewer, $staffPenilai->name));
                }

                // Email ke kandidat
                $dataEmailKandidat = [
                    'namaMahasiswa' => $k->namaMahasiswa,
                    'namaLowongan' => $judulLowongan,
                    'namaUnit' => $k->namaUnit ?? '-',
                    'emailUnit' => $k->emailUnit ?? '-',
                    'kontakUnit' => $k->kontakUnit ?? '-',
                    'tanggal' => $slot['tanggal'],
                    'mulai' => $slot['mulai'],
                    'selesai' => $slot['selesai'],
                    'lokasi' => $lokasi,
                    'link' => $linkWawancara,
                ];

                Mail::to($k->emailMahasiswa)
                    ->send(new InterviewCandidateMail($dataEmailKandidat));
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menjadwalkan '.$kandidat->count().' kandidat secara otomatis.',
        ]);
    }

    private function generateSlots($startDate, $endDate, $jumlahKandidat): array
    {
        $jamMulaiKerja = 8;
        $jamSelesaiKerja = 16;
        $durasiMenit = 60;

        $slots = [];

        $tanggal = Carbon::parse($startDate)->startOfDay();
        $batasAkhir = Carbon::parse($endDate)->startOfDay();
        $hariIni = Carbon::now('Asia/Jakarta')->startOfDay();

        if ($tanggal->lt($hariIni)) {
            $tanggal = $hariIni->copy();
        }

        while ($tanggal->lte($batasAkhir) && count($slots) < $jumlahKandidat) {

            if ($tanggal->isWeekend()) {
                $tanggal->addDay();

                continue;
            }

            $waktuMulai = $tanggal->copy()->setTime($jamMulaiKerja, 0);
            $waktuAkhirHari = $tanggal->copy()->setTime($jamSelesaiKerja, 0);

            while (
                $waktuMulai->copy()->addMinutes($durasiMenit)->lte($waktuAkhirHari)
                && count($slots) < $jumlahKandidat
            ) {
                $waktuSelesai = $waktuMulai->copy()->addMinutes($durasiMenit);

                $slots[] = [
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'mulai' => $waktuMulai->format('H:i:s'),
                    'selesai' => $waktuSelesai->format('H:i:s'),
                ];

                $waktuMulai->addMinutes($durasiMenit);
            }

            $tanggal->addDay();
        }

        return $slots;
    }

    private function generateSlotPreview($lowongan, $jumlahKandidat): array
    {
        $start = Carbon::parse($lowongan->batasPendaftaran)->addDay();
        $end = Carbon::parse($lowongan->mulaiKerja)->subDays(3);

        return $this->generateSlots($start, $end, $jumlahKandidat);
    }

    public function showReschedule($idJadwal)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'p.id', '=', 'j.idPendaftaran')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->select(
                'j.id',
                'j.idPendaftaran',
                'j.tanggal_wawancara as tanggal',
                'j.waktu_mulai as mulai',
                'j.waktu_selesai as selesai',
                'j.lokasi',
                'j.link_wawancara as link',
                'j.keterangan',
                'j.status',
                'l.id as idLowongan',
                'l.judulLowongan',
                'l.mulaiKerja',
                'u.name as namaMahasiswa'
            )
            ->where('j.id', $idJadwal)
            ->first();

        if (! $jadwal) {
            abort(404, 'Jadwal tidak ditemukan');
        }

        // Penilai yang cancel
        $penilaiGagal = DB::table('wawancara_penilai as w')
            ->join('staffunit as s', 's.id', '=', 'w.idStaffUnit')
            ->join('users as u', 'u.id', '=', 's.idUser')
            ->select('w.id', 'w.idStaffUnit', 'u.name as namaPenilai', 'w.status')
            ->where('w.idJadwalWawancara', $idJadwal)
            ->where('w.status', 'gagal')
            ->get();

        // Penilai yang masih aktif
        $penilaiAktif = DB::table('wawancara_penilai as w')
            ->join('staffunit as s', 's.id', '=', 'w.idStaffUnit')
            ->join('users as u', 'u.id', '=', 's.idUser')
            ->select('w.id', 'w.idStaffUnit', 'u.name as namaPenilai', 'w.status')
            ->where('w.idJadwalWawancara', $idJadwal)
            ->whereIn('w.status', ['belum', 'terjadwal'])
            ->get();

        return view('setwawancara.showreschedule', compact(
            'jadwal',
            'penilaiGagal',
            'penilaiAktif'
        ));
    }

    public function prosesReschedule(Request $request, $idJadwal)
    {
        $request->validate([
            'tanggal_reschedule' => 'required|date',
        ]);

        $jadwalLama = DB::table('jadwal_wawancara')->where('id', $idJadwal)->first();

        if (! $jadwalLama || $jadwalLama->status == 'batal') {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal tidak valid.',
            ], 404);
        }

        $lowongan = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->where('p.id', $jadwalLama->idPendaftaran)
            ->select('l.mulaiKerja')
            ->first();

        $tanggalBaru = Carbon::parse($request->tanggal_reschedule);
        $batasAkhir = Carbon::parse($lowongan->mulaiKerja)->subDays(3);
        $hariIni = Carbon::now('Asia/Jakarta')->startOfDay();

        if ($tanggalBaru->lt($hariIni)) {
            return response()->json(['status' => false, 'message' => 'Tanggal tidak valid.'], 422);
        }

        if ($tanggalBaru->gt($batasAkhir)) {
            return response()->json(['status' => false, 'message' => 'Lewat batas H-3.'], 422);
        }

        if ($tanggalBaru->isWeekend()) {
            return response()->json(['status' => false, 'message' => 'Tidak boleh weekend.'], 422);
        }


        $penilaiCancel = DB::table('wawancara_penilai')
            ->where('idJadwalWawancara', $idJadwal)
            ->where('status', 'gagal')
            ->get();

        if ($penilaiCancel->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada penilai yang cancel.',
            ], 422);
        }

        /**
         * SLOT AUTO GENERATE JAM KERJA
         */
        $slots = $this->generateSlots(
            $tanggalBaru,
            $tanggalBaru->copy()->addDays(7), // range kecil biar aman
            $penilaiCancel->count()
        );

        if (count($slots) < $penilaiCancel->count()) {
            return response()->json([
                'status' => false,
                'message' => 'Slot tidak cukup.',
            ], 422);
        }

        DB::transaction(function () use (
            $jadwalLama,
            $penilaiCancel,
            $slots

        ) {

            foreach ($penilaiCancel as $i => $penilai) {

                $slot = $slots[$i];

                /**
                 * 🔥 BUAT JADWAL BARU PER PENILAI CANCEL
                 * (JADWAL LAMA TIDAK DISENTUH)
                 */
                $idJadwalBaru = DB::table('jadwal_wawancara')->insertGetId([
                    'idProgressTahapan' => $jadwalLama->idProgressTahapan,
                    'idPendaftaran' => $jadwalLama->idPendaftaran,
                    'tanggal_wawancara' => $slot['tanggal'],
                    'waktu_mulai' => $slot['mulai'],
                    'waktu_selesai' => $slot['selesai'],
                    'lokasi' => $jadwalLama->lokasi,
                    'link_wawancara' => $jadwalLama->link_wawancara,
                    'keterangan' => $jadwalLama->keterangan,
                    'status' => 'terjadwal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                /**
                 * 🔥 MASUKKAN PENILAI CANCEL SAJA
                 */
                $token = Str::random(40);

                $idPivot = DB::table('wawancara_penilai')->insertGetId([
                    'idJadwalWawancara' => $idJadwalBaru,
                    'idStaffUnit' => $penilai->idStaffUnit,
                    'status' => 'belum',
                    'token' => $token,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $staff = DB::table('staffunit as s')
                    ->join('users as u', 'u.id', '=', 's.idUser')
                    ->where('s.id', $penilai->idStaffUnit)
                    ->select('u.email', 'u.name')
                    ->first();

                $urlTerima = url("/interview/confirm/$idPivot/terima?token=$token");
                $urlTolak = url("/interview/confirm/$idPivot/tolak?token=$token");

                Mail::to($staff->email)->send(
                    new InterviewInterviewerMail([
                        'namaMahasiswa' => 'Reschedule Interview',
                        'tanggal' => $slot['tanggal'],
                        'mulai' => $slot['mulai'],
                        'selesai' => $slot['selesai'],
                        'lokasi' => $jadwalLama->lokasi,
                        'link' => $jadwalLama->link_wawancara,
                        'urlTerima' => $urlTerima,
                        'urlTolak' => $urlTolak,
                    ], $staff->name)
                );
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Reschedule hanya untuk penilai yang cancel berhasil.',
        ]);
    }

    public function confirmJadwal($idpewawancara, $aksi, Request $request)
    {
        // jadi ini kita perlu tau idanya supaya nemu gak
        $pivot = DB::table('wawancara_penilai')->where('id', $idpewawancara)->first();
        if (! $pivot) {
            abort(404, 'Data penilai tidak ditemukan');
        }

        if ($request->token != $pivot->token) {
            abort(403, 'Token tidak valid');
        }

        $jadwal = DB::table('jadwal_wawancara')
            ->where('id', $pivot->idJadwalWawancara)
            ->first();

        if ($jadwal->status == 'batal') {
            return view('mail.interviewconfirm', [
                'aksi' => 'jadwal_batal',
            ]);
        }

        if ($pivot->status != 'belum') {
            return view('mail.interviewconfirm', [
                'aksi' => 'expired',
            ]);
        }

        if ($aksi == 'terima') {
            DB::table('wawancara_penilai')->where('id', $idpewawancara)
                ->update(['status' => 'terjadwal']);
            DB::table('jadwal_wawancara')->where('id', $pivot->idJadwalWawancara)
                ->update(['status' => 'terjadwal']);
        } elseif ($aksi == 'tolak') {
            DB::table('wawancara_penilai')->where('id', $idpewawancara)
                ->update(['status' => 'gagal']);
            // kita cek apabila lebih dari 1 interviwer
            $terima = DB::table('wawancara_penilai')
                ->where('idJadwalWawancara', $pivot->idJadwalWawancara)
                ->where('status', 'terjadwal')
                ->count();
            $pending = DB::table('wawancara_penilai')
                ->where('idJadwalWawancara', $pivot->idJadwalWawancara)
                ->where('status', 'belum')
                ->count();

            if ($terima == 0 && $pending == 0) {
                // semua nolak → jadwal batal
                DB::table('jadwal_wawancara')->where('id', $pivot->idJadwalWawancara)
                    ->update(['status' => 'batal']);
                $jadwal = DB::table('jadwal_wawancara')
                    ->select(
                        'idPendaftaran',
                        'tanggal_wawancara as tanggal',
                        'waktu_mulai as mulai',
                        'waktu_selesai as selesai')
                    ->where('id', $pivot->idJadwalWawancara)
                    ->first();
                $pendaftaran = DB::table('pendaftaran as p')
                    ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
                    ->join('users as u', 'm.idUser', '=', 'u.id')
                    ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
                    ->join('jadwal_wawancara as j', 'j.idPendaftaran', '=', 'p.id')
                    ->select('u.email',
                        'u.name as namaMahasiswa',
                        'l.judulLowongan as namaLowongan')
                    ->where('p.id', $jadwal->idPendaftaran)
                    ->first();
                $dataEmailGagal = [
                    'namaMahasiswa' => $pendaftaran->namaMahasiswa,
                    'namaLowongan' => $pendaftaran->namaLowongan,
                    'tanggal' => $jadwal->tanggal,
                    'mulai' => $jadwal->mulai,
                    'selesai' => $jadwal->selesai,
                ];
                Mail::to($pendaftaran->email)->send(new InterviewUpdateCandidateMail($dataEmailGagal));
            }
        }

        return view('mail.interviewconfirm', ['aksi' => $aksi]);
    }

    public function listPerluReschedule()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        // Jadwal yang punya penilai berstatus 'gagal' dan jadwal masih aktif
        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'p.id', '=', 'j.idPendaftaran')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->select(
                'j.id as idJadwal',
                'j.tanggal_wawancara as tanggal',
                'j.waktu_mulai as mulai',
                'j.waktu_selesai as selesai',
                'j.status',
                'u.name as namaMahasiswa',
                'l.judulLowongan as namaLowongan',
                'l.id as idLowongan',
                DB::raw('(SELECT COUNT(*) FROM wawancara_penilai WHERE idJadwalWawancara = j.id AND status = "gagal") as jumlahCancel'),
                DB::raw('(SELECT COUNT(*) FROM wawancara_penilai WHERE idJadwalWawancara = j.id AND status != "gagal") as jumlahAktif')
            )
            ->where('l.idUnit', $idUnit)
            ->where('j.status', '=', 'batal')
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('wawancara_penilai as w')
                    ->whereColumn('w.idJadwalWawancara', 'j.id')
                    ->where('w.status', 'gagal');
            })
            ->orderBy('j.tanggal_wawancara', 'asc')
            ->get();

        return view('setwawancara.listreschedule', compact('jadwal'));
    }
}

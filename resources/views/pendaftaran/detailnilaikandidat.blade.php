@extends('layouts.app')
@section('breadcrumb', 'DetailPenilaian')

@section('content')
    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius:24px;">
            <div class="px-4 py-4 text-white" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-10 d-flex justify-content-center align-items-center"
                        style="width:72px;height:72px;border-radius:20px;">
                        <i class="material-symbols-rounded text-dark" style="font-size:38px;">
                            person
                        </i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1 text-white">
                            {{ $kandidat->namaKandidat }}
                        </h3>
                        <p class="mb-0 opacity-75">
                            Detail hasil evaluasi kandidat berdasarkan proses wawancara dan penilaian.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">
                            Lowongan
                        </small>
                        <div class="fw-semibold text-dark fs-6">
                            {{ $kandidat->judulLowongan }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">
                            Posisi
                        </small>
                        <div class="fw-semibold text-dark fs-6">
                            {{ $kandidat->posisiLowongan }}
                        </div>
                    </div>

                    {{-- PENILAI --}}
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">
                            Jumlah Penilai
                        </small>
                        <div class="fw-bold text-info fs-6">
                            {{ $summary->jumlahPenilai }} Penilai
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($penilaian as $p)
            <div class="card shadow-sm border-0 mb-4" style="border-radius:18px; overflow:hidden;">
                <div class="px-4 py-3 border-bottom bg-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $p->namaPenilai }}
                            </h5>
                            <small class="text-muted">
                                Tanggal Penilaian :
                                {{ \Carbon\Carbon::parse($p->tanggal_wawancara)->translatedFormat('d M Y') }}
                            </small>
                        </div>

                        <div class="text-end">
                            <small class="text-muted d-block">
                                Total Nilai
                            </small>
                            <h3 class="fw-bold text-info mb-0">
                                {{ number_format($p->nilaiFinal, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs fw-bold">
                                    No
                                </th>
                                <th class="text-uppercase text-secondary text-xxs fw-bold">
                                    Nama Kriteria
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs fw-bold">
                                    Nilai Awal
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs fw-bold">
                                    Bobot
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs fw-bold">
                                    Nilai Akhir
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailKriteria[$p->idPenilaian] ?? [] as $index => $detail)
                                <tr>
                                    <td class="text-center text-sm">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="text-sm fw-semibold">
                                        {{ $detail->namaKriteria }}
                                    </td>
                                    <td class="text-center text-sm">
                                        {{ $detail->nilaiAwal }}
                                    </td>
                                    <td class="text-center text-sm">
                                        {{ $detail->bobotKriteria }}
                                    </td>
                                    <td class="text-center text-sm fw-bold text-success">
                                        {{ number_format($detail->nilaiAkhir, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        <div class="card border-0 shadow-sm mt-4"
            style="border-radius:18px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); overflow:hidden;">

            <div class="card-body py-4 px-4 text-center text-white">
                <h6 class="fw-semibold mb-1 text-white">
                    Nilai Akhir Kandidat
                </h6>
                <h2 class="fw-bold mb-2 text-white" style="font-size:38px;">

                    {{ number_format($summary->nilaiAkhir, 2) }} 

                </h2>
                <small class="opacity-75">
                    Berdasarkan {{ $summary->jumlahPenilai }} penilai
                </small>
            </div>
        </div>
    </div>
@endsection

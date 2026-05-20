@extends('layouts.app')
@section('breadcrumb', 'Detail Penilaian')

@section('content')
    <div class="container-fluid py-4">
        {{-- HEADER --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 18px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold">
                            Detail Penilaian Mahasiswa
                        </small>
                        <h3 class="fw-bold mb-1 mt-1">
                            {{ $penilaian->namaMahasiswa }}
                        </h3>
                        <p class="text-muted mb-0">
                            {{ $penilaian->judulLowongan }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL PENILAIAN --}}
        <div class="card border-0 shadow-sm" style="border-radius: 18px;">
            <div class="card-header bg-dark text-white py-3"
                style="border-top-left-radius: 18px; border-top-right-radius: 18px;">
                <div class="d-flex align-items-center">
                    <i class="material-symbols-rounded me-2">
                        analytics
                    </i>
                    <h6 class="mb-0 text-white fw-bold">
                        Detail Penilaian Kriteria
                    </h6>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs fw-bold opacity-7 text-center">
                                    No
                                </th>
                                <th class="text-uppercase text-secondary text-xxs fw-bold opacity-7">
                                    Kriteria Penilaian
                                </th>
                                <th class="text-uppercase text-secondary text-xxs fw-bold opacity-7 text-center">
                                    Nilai
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($detail as $index => $d)
                                <tr>
                                    <td class="text-center">
                                        <span class="text-sm fw-semibold">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm fw-bold">
                                                {{ $d->nama }}
                                            </h6>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success px-3 py-2">
                                            {{ $d->nilai }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3" class="p-0 border-0 pt-3">
                                    <div
                                        class="d-flex justify-content-between align-items-center bg-light rounded-3 px-4 py-3">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">
                                                Total Nilai Akhir
                                            </h6>
                                            <small class="text-muted">
                                                Hasil akhir penilaian kinerja mahasiswa
                                            </small>
                                        </div>
                                        <span class="badge bg-success px-4 py-3 fs-6">
                                            {{ number_format($penilaian->total_nilai, 2) }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

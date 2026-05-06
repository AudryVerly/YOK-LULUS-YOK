@extends('layouts.app')
@section('breadcrumb', 'List Mahasiswa')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-1">List Mahasiswa</h4>
            <small class="text-muted">Pilih mahasiswa untuk melakukan penilaian kinerja</small>
        </div>
        <div class="row g-4">
            @forelse($data as $d)
                <div class="col-xl-4 col-md-6">

                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

                        {{-- HEADER --}}
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

                            <div>
                                <h6 class="mb-0 fw-bold text-white">
                                    {{ $d->name }}
                                </h6>
                                <small class="text-light">
                                    {{ $d->judulLowongan }}
                                </small>
                            </div>

                            {{-- BADGE STATUS --}}
                            <div class="text-end">

                                @if ($d->status_penilaian == 'belum_mulai')
                                    <span class="badge bg-warning text-dark">
                                        Belum Mulai
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @endif

                                <br>

                                @if ($d->sudah_dinilai)
                                    <span class="badge bg-primary mt-1">
                                        Sudah Dinilai
                                    </span>
                                @else
                                    <span class="badge bg-danger mt-1">
                                        Belum Dinilai
                                    </span>
                                @endif

                            </div>

                        </div>

                        {{-- BODY --}}
                        <div class="card-body p-4">

                            <div class="small text-muted mb-3">

                                <div class="d-flex align-items-center justify-content-between">

                                    <div class="text-center">
                                        <div class="fw-semibold text-dark">
                                            {{ \Carbon\Carbon::parse($d->mulaiKerja)->format('d M Y') }}
                                        </div>
                                        <small>Mulai</small>
                                    </div>

                                    <div class="flex-grow-1 border-top mx-2"></div>

                                    <div class="text-center">
                                        <div class="fw-semibold text-dark">
                                            {{ \Carbon\Carbon::parse($d->akhirKerja)->format('d M Y') }}
                                        </div>
                                        <small>Akhir</small>
                                    </div>

                                </div>

                            </div> 

                            <p class="text-muted small mb-3">
                                Kandidat dalam unit ini dapat dinilai berdasarkan performa kerja selama periode aktif.
                            </p>

                            {{-- BUTTON --}}
                            @if ($d->status_penilaian == 'boleh_dinilai')
                                @if (!$d->sudah_dinilai)
                                    <a href="{{ route('kinerjaform.form',[$d->idMahasiswa,$d->idLowongan]) }}" class="btn btn-success w-100 rounded-pill">
                                        Mulai Penilaian
                                    </a>
                                @else
                                    <button class="btn btn-outline-primary w-100 rounded-pill" disabled>
                                        Sudah Dinilai
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-outline-warning w-100 rounded-pill" disabled>
                                    Belum Waktunya
                                </button>
                            @endif

                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center">
                        Tidak ada mahasiswa di unit ini
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

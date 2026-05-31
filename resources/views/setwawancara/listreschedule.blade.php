@extends('layouts.app')
@section('breadcrumb', 'Jadwal Perlu Reschedule')

@section('content')
    <div class="container-fluid px-4 py-3">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-0 fw-semibold">Jadwal Perlu Perhatian</h5>
                <small class="text-muted">Jadwal dengan penilai yang membatalkan kehadiran</small>
            </div>
        </div>

        @if ($jadwal->isEmpty())
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-check2-circle text-success" style="font-size:3rem"></i>
                    <p class="mt-3 mb-0 text-muted">Tidak ada jadwal yang perlu reschedule. Semua berjalan lancar!</p>
                </div>
            </div>
        @else
            <div class="row g-3" id="jadwalContainer">
                @foreach ($jadwal as $j)
                    <div class="col-md-6 col-xl-4 jadwal-card" data-nama="{{ strtolower($j->namaMahasiswa) }}"
                        data-lowongan="{{ strtolower($j->namaLowongan) }}">
                        <div class="card shadow-sm h-100 border-start border-warning border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-semibold mb-0">{{ $j->namaMahasiswa }}</h6>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-person-x me-1"></i>{{ $j->jumlahCancel }} cancel
                                    </span>
                                </div>
                                <p class="text-muted small mb-2">{{ $j->namaLowongan }}</p>

                                <div class="d-flex gap-3 text-muted small mb-3">
                                    <span><i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($j->tanggal)->isoFormat('D MMM YYYY') }}
                                    </span>
                                    <span><i class="bi bi-clock me-1"></i>
                                        {{ substr($j->mulai, 0, 5) }} – {{ substr($j->selesai, 0, 5) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $j->jumlahAktif }} penilai aktif
                                    </small>
                                    <a href="{{ route('generatewawancara.showreschedule', $j->idJadwal) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-arrow-repeat me-1"></i> Reschedule
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Empty state saat filter kosong --}}
            <div id="emptySearch" class="text-center py-5 d-none">
                <i class="bi bi-search text-muted" style="font-size:2rem"></i>
                <p class="mt-2 text-muted mb-0">Tidak ada hasil untuk pencarian tersebut.</p>
            </div>

        @endif
    </div>

    {{-- Toast --}}
    <div class="position-fixed bottom-0 end-0 m-3" style="z-index:9999">
        <div id="toastMsg" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastBody"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#searchInput').on('input', function() {
                    var keyword = $(this).val().toLowerCase().trim();
                    var visible = 0;

                    $('.jadwal-card').each(function() {
                        var nama = $(this).data('nama');
                        var lowongan = $(this).data('lowongan');
                        var match = nama.indexOf(keyword) !== -1 || lowongan.indexOf(keyword) !== -1;

                        $(this).toggleClass('d-none', !match);
                        if (match) visible++;
                    });

                    $('#emptySearch').toggleClass('d-none', visible > 0);
                });
                function showToast(message, type) {
                    type = type || 'success';
                    var $toast = $('#toastMsg');
                    $('#toastBody').text(message);
                    $toast.attr('class', 'toast align-items-center text-bg-' + type + ' border-0 show');
                    var bsToast = new bootstrap.Toast($toast[0], {
                        delay: 3500
                    });
                    bsToast.show();
                }

            });
        </script>
    @endpush
@endsection

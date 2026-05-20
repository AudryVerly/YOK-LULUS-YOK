@extends('layouts.app')
@section('breadcrumb', 'List Mahasiswa')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-1">List Mahasiswa</h4>
            <small class="text-muted">Pilih mahasiswa untuk melakukan penilaian kinerja</small>
        </div>
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <input type="text" id="searchMahasiswa" class="form-control border rounded-3 shadow-sm px-3 py-2"
                    placeholder="Cari Nama Mahasiswa">
            </div>

            <div class="col-md-4">
                <input type="text" id="searchLowongan" class="form-control border rounded-3 shadow-sm px-3 py-2"
                    placeholder="Cari Lowongan">
            </div>
        </div>
        <div class="row g-4" id="mahasiswaContainer">
            @forelse($data as $d)
                <div class="col-xl-4 col-md-6 mahasiswa-item">

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
                                    <a href="{{ route('kinerjaform.form', [$d->idMahasiswa, $d->idLowongan]) }}"
                                        class="btn btn-success w-100 rounded-pill">
                                        Mulai Penilaian
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary w-100 rounded-pill" disabled
                                        style="cursor: not-allowed; pointer-events: all; opacity: 0.7;">
                                        Sudah Dinilai
                                    </button>

                                    <a href="{{ route('penilaian.detail', [$d->idMahasiswa, $d->idLowongan]) }}"
                                        class="btn btn-info w-100 rounded-pill">
                                        Detail Penilaian
                                    </a>
                                @endif
                            @else
                                <button class="btn btn-outline-warning w-100 rounded-pill" disabled
                                    style="cursor: not-allowed; pointer-events: all; opacity: 0.7;">
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
        <div class="d-flex justify-content-center mt-4">
            <div id="pagination-container"></div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
    <script>
        $(document).ready(function() {

            let items = $('.mahasiswa-item');
            let perPage = 6;

            function showPage(pageNumber) {

                let visibleItems = items.filter(function() {
                    return $(this).css('display') !== 'none';
                });

                items.hide();

                let showFrom = perPage * (pageNumber - 1);
                let showTo = showFrom + perPage;

                visibleItems.slice(showFrom, showTo).show();
            }

            function setupPagination() {

                let visibleItems = items.filter(function() {
                    return $(this).css('display') !== 'none';
                });

                $('#pagination-container').pagination('destroy');

                $('#pagination-container').pagination({
                    items: visibleItems.length,
                    itemsOnPage: perPage,

                    prevText: "&laquo;",
                    nextText: "&raquo;",

                    cssStyle: '',

                    onPageClick: function(pageNumber) {
                        showPage(pageNumber);
                    }
                });

                showPage(1);
            }

            function filterMahasiswa() {

                let keywordMahasiswa = $('#searchMahasiswa').val().toLowerCase().trim();
                let keywordLowongan = $('#searchLowongan').val().toLowerCase().trim();

                items.each(function() {

                    let nama = $(this).find('h6').text().toLowerCase().trim();

                    let lowongan = $(this).find('.text-light')
                        .text()
                        .toLowerCase()
                        .trim();

                    let matchMahasiswa = nama.includes(keywordMahasiswa);

                    let matchLowongan = lowongan.includes(keywordLowongan);

                    if (matchMahasiswa && matchLowongan) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }

                });

                setupPagination();
            }

            setupPagination();

            $('#searchMahasiswa').on('keyup', filterMahasiswa);
            $('#searchLowongan').on('keyup', filterMahasiswa);
        });
    </script>
@endpush

@extends('layouts.app')
@section('breadcrumb', 'List Student Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <input type="text" id="searchMahasiswa" class="form-control border rounded-3 shadow-sm px-3 py-2"
                    placeholder="Cari Mahasiswa">
            </div>

            <div class="col-md-3">
                <input type="text" id="searchLowongan" class="form-control border rounded-3 shadow-sm px-3 py-2"
                    placeholder="Cari Lowongan">
            </div>
        </div>
        <div class="row" id="cardContainer">
            @forelse ($mahasiswa as $m)
                <div class="col-md-6 col-xl-4 mb-4 card-item">
                    <div class="card shadow-lg border-0 h-100 d-flex flex-column">
                        <div class="card-header bg-gradient-dark text-white">
                            <h6 class="mb-0 fw-bold text-white">
                                {{ $m->namaMahasiswa }}
                            </h6>
                        </div>

                        <div class="card-body flex-grow-1 py-3 px-3">
                            <div class="mb-2">
                                <div class="fw-semibold text-dark">
                                    Lowongan : {{ $m->judulLowongan ?? '-' }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="fw-semibold text-dark">
                                    Unit : {{ $m->namaUnit ?? '-' }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="fw-semibold text-dark"> Status :

                                    @if ($m->statusPendaftaran == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pt-2 pb-3 px-3">
                            <a href="{{ route('tugasadmin.listtugasadmin', [$m->idMahasiswa, $m->idLowongan]) }}"
                                class="btn btn-outline-primary w-100">
                                Lihat Detail Tugas
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h6 class="text-muted">Belum ada mahasiswa yang diterima</h6>
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
            let items = $('.card-item');
            let perPage = 8;

            function showPage(pageNumber) {

                let visibleItems = items.filter(function() {
                    return $(this).data('filtered') !== false;
                });

                items.hide();

                let showFrom = perPage * (pageNumber - 1);
                let showTo = showFrom + perPage;

                visibleItems.slice(showFrom, showTo).show();
            }

            function setupPagination() {

                let visibleItems = items.filter(function() {
                    return $(this).data('filtered') !== false;
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

                let keywordMahasiswa = $('#searchMahasiswa')
                    .val()
                    .toLowerCase()
                    .trim();

                let keywordLowongan = $('#searchLowongan')
                    .val()
                    .toLowerCase()
                    .trim();

                items.each(function() {

                    let namaMahasiswa = $(this)
                        .find('.card-header h6')
                        .text()
                        .toLowerCase()
                        .trim();

                    let namaLowongan = $(this)
                        .find('.card-body .fw-semibold')
                        .first()
                        .text()
                        .replace('Lowongan :', '')
                        .toLowerCase()
                        .trim();

                    let cocokMahasiswa =
                        namaMahasiswa.includes(keywordMahasiswa);

                    let cocokLowongan =
                        namaLowongan.includes(keywordLowongan);

                    $(this).data(
                        'filtered',
                        cocokMahasiswa && cocokLowongan
                    );
                });

                setupPagination();
            }

            $('#searchMahasiswa').on('keyup', filterMahasiswa);
            $('#searchLowongan').on('keyup', filterMahasiswa);

            setupPagination();
        });
    </script>
@endpush

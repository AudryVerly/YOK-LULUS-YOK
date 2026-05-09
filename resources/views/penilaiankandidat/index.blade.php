@extends('layouts.app')
@section('breadcrumb', 'List Kandidat Dinilai')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Penilaian Kandidat</h3>
                <small class="text-muted">Pilih Kandidat Untuk dinilai</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="text" id="searchMahasiswa" class="form-control border rounded-3 shadow-sm px-3 py-2"
                    placeholder="Cari Nama Mahasiswa">
            </div>
        </div>

        <div class="row" id="kandidatContainer">
            @foreach ($kandidat as $k)
                @php
                    $now = \Carbon\Carbon::now('Asia/Jakarta');
                    $jadwal = \Carbon\Carbon::parse($k->tanggalWawancara);
                @endphp
                <div class="col-md-4 mb-4 kandidat-item">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold">{{ $k->namaKandidat }}</h5>
                                @if ($k->status == 'terjadwal')
                                    <span class="badge bg-danger text-white">Belum Dinilai</span>
                                @else
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                @endif
                            </div>
                            <p class="mb-1 text-muted">{{ $k->namaLowongan }}</p>
                            <small class="text-secondary">{{ $k->posisiLowongan }}</small>

                            <div class="mt-3 d-flex justify-content-end">
                                @if ($k->status == 'terjadwal')
                                    @if ($now->gte($jadwal))
                                        <a href="{{ route('penilaian.formMenilai', $k->id) }}" class="btn btn-success">
                                            Nilai
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            Belum Waktunya
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('penilaian.detailNilaiKandidat', $k->id) }}"
                                        class="btn btn-outline-success btn-sm">
                                        Lihat Hasil
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            <div id="pagination-container"></div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
    <script>
        $(document).ready(function() {

            let items = $('.kandidat-item');
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

                let keyword = $('#searchMahasiswa').val().toLowerCase();

                items.each(function() {

                    let nama = $(this).find('h5').text().toLowerCase();

                    if (nama.includes(keyword)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }

                });

                setupPagination();
            }

            setupPagination();

            $('#searchMahasiswa').on('keyup', filterMahasiswa);

        });
    </script>
@endpush

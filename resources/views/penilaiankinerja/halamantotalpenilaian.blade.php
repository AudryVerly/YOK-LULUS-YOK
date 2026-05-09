@extends('layouts.app')
@section('breadcrumb', 'Total Penilaian Kinerja')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4 g-3">
            <div class="col-md-3 ">
                <input type="text" id="searchKandidat" placeholder="Cari Mahasiswa"
                    class="form-control border rounded-3 shadow-sm px-3 py-2">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control border rounded-3 shadow-sm px-3 py-2" id="searchLowongan"
                    placeholder="Cari Lowongan">
            </div>
            <div class="col-md-3">
                <select id="searchUnit" class="form-select border rounded-3 shadow-sm px-3 py-2">
                    <option value="">Semua Unit</option>

                    @foreach ($units as $unit)
                        <option value="{{ strtolower($unit->name) }}">
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" id="cardContainer">
            @foreach ($data as $d)
                <div class="col-md-6 col-xl-4 mb-4 card-item">
                    <div class="card shadow-lg border-0 h-100 d-flex flex-column">
                        <div class="card-header bg-gradient-dark text-white">
                            <h6 class="mb-0 fw-bold text-white">{{ $d->namaMahasiswa }}</h6>
                            <small class="text-light">{{ $d->judulLowongan }}</small>
                        </div>
                        <div class="card-body py-4 text-center">
                            <small class="text-muted">Total Nilai</small>
                            <h2 class="fw-bold text-info">{{ $d->totalNilai }}</h2>
                            <div class="mt-2">
                                <span class="badge px-3 py-2 bg-success">{{ $d->kategori }}</span>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted d-block">Unit: {{ $d->name }}</small>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Periode Kerja:
                                {{ \Carbon\Carbon::parse($d->mulaiKerja)->translatedFormat('d M Y') }}
                                -
                                {{ \Carbon\Carbon::parse($d->akhirKerja)->translatedFormat('d M Y') }}
                            </small>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3 d-flex gap-2">
                            @if ($d->adaTugas)
                                <button class="btn btn-outline-primary w-50 rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#modalTugas-{{ $d->idMahasiswa }}-{{ $d->idLowongan }}">
                                    Tugas
                                </button>
                            @else
                                <button class="btn btn-outline-secondary w-50 rounded-pill" disabled>
                                    Tugas
                                </button>
                            @endif

                            @if ($d->adaForm)
                                <button class="btn btn-outline-info w-50 rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#modalForm-{{ $d->idMahasiswa }}-{{ $d->idLowongan }}">
                                    Form
                                </button>
                            @else
                                <button class="btn btn-outline-secondary w-50 rounded-pill" disabled>
                                    Form
                                </button>
                            @endif
                        </div>

                        {{-- Total nilai kecil di bawah --}}
                        <div class="px-3 pb-3 text-end">
                            <small class="text-muted">
                                Dihitung dari:
                                @if ($d->adaTugas && $d->adaForm)
                                    totalAkhir -> (rataTugas + rataForm) / 2
                                @elseif ($d->adaTugas)
                                    nilai tugas saja
                                @else
                                    nilai form saja
                                @endif
                            </small>
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
@push('modals')
    @foreach ($data as $d)
        {{-- ===== MODAL TUGAS ===== --}}
        <div class="modal fade" id="modalTugas-{{ $d->idMahasiswa }}-{{ $d->idLowongan }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-dark text-white px-4 py-3 border-0">
                        <div>
                            <h5 class="modal-title text-white mb-1"> Detail Penilaian Tugas</h5>
                            <small class="text-light">{{ $d->namaMahasiswa }} — {{ $d->judulLowongan }}</small>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 py-3">

                        <p class="mb-1"><strong>Unit:</strong> {{ $d->name }}</p>
                        <p class="mb-3">
                            <strong>Periode:</strong>
                            {{ \Carbon\Carbon::parse($d->mulaiKerja)->translatedFormat('d M Y') }}
                            –
                            {{ \Carbon\Carbon::parse($d->akhirKerja)->translatedFormat('d M Y') }}
                        </p>
                        <hr>

                        @forelse ($d->detailTugas as $t)
                            <div class="border rounded-4 p-3 mb-3 bg-light">
                                <h6 class="fw-bold text-dark mb-3">{{ $t->namaTugas }}</h6>
                                <div class="row g-2 text-center">
                                    <div class="col-3">
                                        <small class="text-muted d-block">Nilai Awal</small>
                                        <span class="fw-bold text-dark">{{ $t->nilaiAwal ?? '-' }}</span>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-muted d-block">Bobot</small>
                                        <span class="fw-bold text-warning">{{ $t->bobotNilai }}%</span>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-muted d-block">Penalti</small>
                                        <span class="fw-bold text-danger">{{ $t->penalti ?? '-' }}</span>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-muted d-block">Nilai Akhir</small>
                                        <span class="fw-bold text-primary">{{ $t->nilaiAkhir ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted d-block">Catatan</small>
                                    <div class="fw-semibold text-dark">{{ $t->catatan ?? '-' }}</div>
                                </div>
                                <small class="text-muted fst-italic">
                                    *Nilai akhir = (Nilai Awal - Penalti) × Bobot / 100
                                </small>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">Belum ada penilaian tugas</div>
                        @endforelse
                    </div>
                    @if ($d->detailTugas->isNotEmpty())
                        @php
                            $totalBobot = $d->detailTugas->sum('bobotNilai');
                            $totalNilaiAkhir = $d->detailTugas->sum('nilaiAkhir');
                            $nilaiTugas = $totalBobot > 0 ? round(($totalNilaiAkhir / $totalBobot) * 100, 2) : 0;
                        @endphp
                        <div class="border rounded-4 p-3 bg-white">
                            <h6 class="fw-bold mb-3 text-dark">Ringkasan Nilai Tugas</h6>
                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <small class="text-muted d-block">Total Bobot</small>
                                    <span class="fw-bold text-warning">{{ $totalBobot }}%</span>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Total Nilai Akhir</small>
                                    <span class="fw-bold text-primary">{{ $totalNilaiAkhir }}</span>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Rata-rata Tugas</small>
                                    <span class="fw-bold text-info fs-5">{{ $nilaiTugas }}</span>
                                </div>
                            </div>
                            <small class="text-muted fst-italic d-block mt-2">
                                *Rata-rata tugas = (Total Nilai Akhir / Total Bobot) × 100
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalForm-{{ $d->idMahasiswa }}-{{ $d->idLowongan }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-dark text-white px-4 py-3 border-0">
                        <div>
                            <h5 class="modal-title text-white mb-1"> Detail Penilaian Form</h5>
                            <small class="text-light">{{ $d->namaMahasiswa }} — {{ $d->judulLowongan }}</small>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 py-3">

                        <p class="mb-1"><strong>Unit:</strong> {{ $d->name }}</p>
                        <p class="mb-3">
                            <strong>Periode:</strong>
                            {{ \Carbon\Carbon::parse($d->mulaiKerja)->translatedFormat('d M Y') }}
                            –
                            {{ \Carbon\Carbon::parse($d->akhirKerja)->translatedFormat('d M Y') }}
                        </p>
                        <hr>

                        @forelse ($d->detailForm as $f)
                            <div class="border rounded-4 p-3 mb-4 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark">{{ $f->namaStaff }}</span>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($f->tanggal_menilai)->translatedFormat('d M Y') }}
                                    </small>
                                </div>

                                {{-- Tabel Kriteria --}}
                                @if ($f->kriteria->isNotEmpty())
                                    <div class="table-responsive mb-2">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>Kriteria</th>
                                                    <th class="text-center" style="width:80px">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($f->kriteria as $k)
                                                    <tr>
                                                        <td>{{ $k->namaKriteria }}</td>
                                                        <td class="text-center fw-bold">{{ $k->nilai }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <td class="fw-bold text-end">Rata-rata</td>
                                                    <td class="text-center fw-bold text-primary">{{ $f->total_nilai }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @endif
                                <small class="text-muted d-block">Catatan</small>
                                <div class="fw-semibold text-dark">{{ $f->catatan ?? '-' }}</div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">Belum ada penilaian form</div>
                        @endforelse

                    </div>
                    <div class="modal-footer border-0 px-4 pb-3 justify-content-between align-items-center">
                        <small class="text-muted">Total nilai form sudah terhitung ke nilai akhir</small>
                        <span class="fw-bold text-info fs-5">
                            <span class="badge bg-success ms-1">{{ $d->kategori }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush
@push('scripts')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
    <script>
        $(document).ready(function() {
            let items = $('.card-item');
            let perPage = 6;

            function showPage(pageNumber) {

                let showFrom = perPage * (pageNumber - 1);
                let showTo = showFrom + perPage;

                items.hide().slice(showFrom, showTo).show();
            }

            $('#pagination-container').pagination({
                items: items.length,
                itemsOnPage: perPage,

                prevText: "&laquo;",
                nextText: "&raquo;",

                cssStyle: '',

                onPageClick: function(pageNumber) {
                    showPage(pageNumber);
                }
            });

            $('#pagination-container').pagination('selectPage', 1);

            function filterData() {

                let kandidat = $('#searchKandidat').val().toLowerCase().trim();
                let lowongan = $('#searchLowongan').val().toLowerCase().trim();
                let unit = $('#searchUnit').val().toLowerCase().trim();

                $('.col-md-6.col-xl-4.mb-4').each(function() {

                    let card = $(this);

                    let namaMahasiswa = card.find('.card-header h6').text().toLowerCase().trim();

                    let namaLowongan = card.find('.card-header small').text().toLowerCase().trim();

                    let namaUnit = card.find('.card-body .text-muted.d-block')
                        .text()
                        .replace('unit:', '')
                        .replace('Unit:', '')
                        .toLowerCase()
                        .trim();

                    let cocokMahasiswa = namaMahasiswa.includes(kandidat);
                    let cocokLowongan = namaLowongan.includes(lowongan);
                   let cocokUnit = unit === '' || namaUnit.includes(unit);

                    if (cocokMahasiswa && cocokLowongan && cocokUnit) {
                        card.show();
                    } else {
                        card.hide();
                    }

                });

            }

            $('#searchKandidat').on('keyup', filterData);
            $('#searchLowongan').on('keyup', filterData);
            $('#searchUnit').on('change', filterData);

        });
    </script>
@endpush

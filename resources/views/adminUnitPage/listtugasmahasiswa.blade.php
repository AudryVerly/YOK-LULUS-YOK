@extends('layouts.app')
@section('breadcrumb', 'List Tugas Student Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-1 fw-bold">{{ $mahasiswa->namaMahasiswa }}</h5>
                <small class="text-muted">Detail Tugas dan Penilaian Form Student Employee</small>
            </div>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-dark">
                <h6 class="mb-0 text-white">Daftar Tugas</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableTugas" class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">No</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nama Tugas</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Bobot</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Deadline</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Status Pengumpulan</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Tanggal Pengumpulan</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Hasil</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Catatan</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nilai</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Penalti</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugas as $index => $t)
                                <tr>
                                    <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->namaTugas }}</td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->bobotNilai }}</td>
                                    <td class="text-sm" style="text-align: center;">
                                        {{ \Carbon\Carbon::parse($t->tenggatPengumpulan)->format('d M Y') }}</td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->statusPengumpulan ?? '-' }}</td>
                                    <td class="text-sm" style="text-align: center;">
                                        {{ $t->tanggalPengumpulan ? \Carbon\Carbon::parse($t->tanggalPengumpulan)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="text-sm" style="text-align: center;">
                                        @if ($t->file_path)
                                            <a href="{{ asset('storage/' . $t->file_path) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->catatan ?? '-' }}</td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->nilaiAwal ?? '-' }}</td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->penalti ?? '-' }}</td>
                                    <td class="text-sm" style="text-align: center;">{{ $t->nilaiAkhir ?? '-' }}
                                        <div class="text-xs text-secondary">
                                            ({{ $t->nilaiAwal }} - {{ $t->penalti }})
                                            x {{ $t->bobotNilai }}%
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-3 shadow-sm border-0 mt-3">
            <div class="card-header bg-dark text-white">
                Penilaian Kinerja
            </div>

            <div class="card-body">

                @forelse ($penilaian as $p)
                    <div class="border rounded p-3 mb-3">

                        <div class="fw-bold mb-2">
                            Total Nilai: {{ $p->total_nilai }}
                        </div>

                        <div class="mb-2">
                            Catatan: {{ $p->catatan ?? '-' }}
                        </div>

                        <div class="mb-2">
                            Tanggal: {{ \Carbon\Carbon::parse($p->tanggal_menilai)->format('d M Y') }}
                        </div>

                        <hr>

                        <div class="fw-bold mb-2">Kriteria</div>

                        @foreach ($kriteria[$p->id] ?? [] as $k)
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <span>{{ $k->nama }}</span>
                                <span class="fw-bold">{{ $k->nilai }}</span>
                            </div>
                        @endforeach

                    </div>
                @empty
                    <p class="text-muted">Belum ada penilaian</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableTugas').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: "Belum ada Tugas yang diberikan",
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                columnDefs: [
                    //ini supaya tabel index terakhir gak bisa disort
                    {
                        orderable: false,
                        targets: -1
                    }
                ]
            });
        });
    </script>
@endpush

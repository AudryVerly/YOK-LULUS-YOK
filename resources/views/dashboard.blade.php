@extends('layouts.app')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">

        {{-- Statistik Utama --}}
        <div class="row g-4">
            {{-- Total User --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total User
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalUser }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-dark text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    person
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($userPerRole as $role => $jumlah)
                                <span class="badge bg-gradient-secondary">
                                    {{ $role }} : {{ $jumlah }}
                                </span>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            {{-- Total Unit --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total Unit
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalUnit }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    apartment
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <p class="mb-0 text-sm">
                            <span class="text-success fw-bold">
                                {{ $unitAktif }} aktif
                            </span>

                            &nbsp;•&nbsp;

                            <span class="text-secondary">
                                {{ $unitNonaktif }} nonaktif
                            </span>
                        </p>

                    </div>
                </div>
            </div>

            {{-- Total Mahasiswa --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total Mahasiswa
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalMahasiswa }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    school
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <p class="mb-0 text-sm">
                            <span class="text-success fw-bold">
                                {{ $mahasiswaAktif }} aktif
                            </span>

                            &nbsp;•&nbsp;

                            <span class="text-secondary">
                                {{ $mahasiswaNonaktif }} nonaktif
                            </span>
                        </p>

                    </div>
                </div>
            </div>

            {{-- Total Staff --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total Staff Unit
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalStaff }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    work
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <p class="mb-0 text-sm text-secondary">
                            Terdaftar di semua unit
                        </p>

                    </div>
                </div>
            </div>

        </div>

        {{-- Statistik Kedua --}}
        <div class="row g-4 mt-1">

            {{-- Total Lowongan --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total Lowongan
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalLowongan }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    task
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <p class="mb-0 text-sm">
                            <span class="text-success fw-bold">
                                {{ $lowonganBuka }} buka
                            </span>

                            &nbsp;•&nbsp;

                            <span class="text-info fw-bold">
                                +{{ $lowonganBaruBulanIni }} bulan ini
                            </span>
                        </p>

                    </div>
                </div>
            </div>

            {{-- Total Pendaftaran --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total Pendaftaran
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalPendaftaran }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    person_raised_hand
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        @php
                            $tren = $pendaftaranBulanIni - $pendaftaranBulanLalu;
                        @endphp

                        <p class="mb-0 text-sm">
                            @if ($tren > 0)
                                <span class="text-success fw-bold">
                                    <i class="fas fa-arrow-up"></i>
                                    +{{ $tren }} dari bulan lalu
                                </span>
                            @elseif ($tren < 0)
                                <span class="text-danger fw-bold">
                                    <i class="fas fa-arrow-down"></i>
                                    {{ $tren }} dari bulan lalu
                                </span>
                            @else
                                <span class="text-secondary">
                                    Sama seperti bulan lalu
                                </span>
                            @endif
                        </p>

                    </div>
                </div>
            </div>

            {{-- Mahasiswa Diterima --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Mahasiswa Diterima
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalDiterima }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    how_to_reg
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <p class="mb-0 text-sm text-secondary">
                            Dari total {{ $totalPendaftaran }} pendaftar
                        </p>
                    </div>
                </div>
            </div>

            {{-- Total Kriteria --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-sm text-uppercase fw-bold text-secondary mb-1">
                                    Total Kriteria
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalKriteria }}
                                </h3>
                            </div>

                            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <span class="material-symbols-rounded" style="font-size:20px;">
                                    view_list
                                </span>
                            </div>
                        </div>

                        <hr class="horizontal dark my-3">

                        <p class="mb-0 text-sm">
                            <span class="text-success fw-bold">
                                {{ $kriteriaAktif }} aktif
                            </span>

                            &nbsp;•&nbsp;

                            <span class="text-secondary">
                                {{ $kriteriaNonaktif }} nonaktif
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="row g-4 mt-1">

            {{-- Lowongan per Unit --}}
            <div class="col-xl-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h6 class="mb-0 fw-bold">
                            Lowongan per Unit
                        </h6>
                    </div>
                    <div class="card-body pt-3">
                        <div class="table-responsive">
                            <table id="tableLowongan" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs fw-bold">
                                            Unit
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs fw-bold text-center">
                                            Total Lowongan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowonganPerUnit as $item)
                                        <tr>
                                            <td>
                                                <p class="text-sm fw-bold mb-0">
                                                    {{ $item->namaUnit }}
                                                </p>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-gradient-dark">
                                                    {{ $item->total }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Pendaftaran --}}
            <div class="col-xl-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h6 class="mb-0 fw-bold">
                            Breakdown Status Pendaftaran
                        </h6>
                    </div>

                    <div class="card-body pt-3">
                        <div class="table-responsive">
                            <table id="tablePendaftaran" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs fw-bold">
                                            Status
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs fw-bold text-center">
                                            Jumlah
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs fw-bold text-center">
                                            Persentase
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pendaftaranPerStatus as $status => $jumlah)
                                        <tr>
                                            <td>
                                                <p class="text-sm fw-bold mb-0 text-capitalize">
                                                    {{ $status }}
                                                </p>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-gradient-dark">
                                                    {{ $jumlah }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="text-sm">
                                                    {{ $totalPendaftaran > 0 ? number_format(($jumlah / $totalPendaftaran) * 100, 1) : 0 }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            $('#tableLowongan').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
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
            })

            $('#tablePendaftaran').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
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
            })
        })
    </script>
@endpush

@extends('layouts.app')
@section('breadcrumb', 'List Lowongan Unit')

@section('content')
    <div class="container-fluid py-2">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                <div
                    class ="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                    <h6 class="text-white text-capitalize m-0">List Lowongan</h6>
                    <a href="{{route('generatewawancara.listreschedule') }}" class="btn btn-sm btn-white">Jadwal Perlu Reschedule</a>
                </div>
            </div>
            <div class="card-body px-0 pb-2 ">
                <div class="table-responsive px-3">
                    <table id="listlowongantable" class="table table-hover align-middle mb-0 text-center table-sm">
                        <thead class="bg-light">
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Lowongan</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Kandidat Wawancara</th>
                            <th
                                class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                Progress
                            </th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Status</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($lowongan as $l)
                                <tr>
                                    <td class="text-sm">{{ $l->judulLowongan }}</td>
                                    <td class="text-sm">{{ $l->totalWawancara }} </td>
                                    <td class="text-sm">
                                        <span class="badge bg-info">
                                            {{ $l->progressGenerate }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($l->statusGenerate == 'Sudah Generate')
                                            <span class="badge bg-success">
                                                {{ $l->statusGenerate }}
                                            </span>
                                        @elseif($l->statusGenerate == 'Belum Lengkap')
                                            <span class="badge bg-warning">
                                                {{ $l->statusGenerate }}
                                            </span>
                                        @elseif($l->statusGenerate == 'Masih Seleksi Awal')
                                            <span class="badge bg-primary">
                                                {{ $l->statusGenerate }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $l->statusGenerate }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('generatewawancara.showautogenerate',$l->id) }}" class="btn btn-primary btn-sm">
                                            Generate Jadwal
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    {{-- ini scriptnya datable --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#listlowongantable').DataTable({
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

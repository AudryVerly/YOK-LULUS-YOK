@extends('layouts.app')

@section('breadcrumb', 'Auto Generate Jadwal Wawancara')

@section('content')
    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center gap-2 mb-4">

            <div>
                <h4 class="mb-0 fw-bold">Auto Generate Jadwal</h4>
                <small class="text-muted">{{ $lowongan->judulLowongan }}</small>
            </div>
        </div>
        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-5">

                {{-- INFO --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold text-dark">
                        Informasi Jadwal
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Batas Daftar</td>
                                <td class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($lowongan->batasPendaftaran)->isoFormat('D MMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Mulai Kerja</td>
                                <td class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($lowongan->mulaiKerja)->isoFormat('D MMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Range</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border">
                                        {{ \Carbon\Carbon::parse($lowongan->batasPendaftaran)->addDay()->isoFormat('D MMM') }}
                                        -
                                        {{ \Carbon\Carbon::parse($lowongan->mulaiKerja)->subDays(3)->isoFormat('D MMM') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kandidat</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $kandidatBelumJadwal->count() }} orang
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Slot</td>
                                <td>
                                    @if (count($previewSlot) >= $kandidatBelumJadwal->count())
                                        <span class="badge bg-success">Cukup</span>
                                    @else
                                        <span class="badge bg-danger">Kurang</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- LIST --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold text-dark">
                        Kandidat
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($kandidatBelumJadwal as $i => $k)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-secondary rounded-circle" style="width:26px;height:26px;">
                                        {{ $i + 1 }}
                                    </span>
                                    <span>{{ $k->namaMahasiswa }}</span>
                                </div>

                                {{-- @if (isset($previewSlot[$i]))
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($previewSlot[$i]['tanggal'])->isoFormat('D MMM') }}
                                        {{ substr($previewSlot[$i]['mulai'], 0, 5) }} -
                                        {{ substr($previewSlot[$i]['selesai'], 0, 5) }}
                                    </small>
                                @else
                                    <span class="badge bg-danger">No slot</span>
                                @endif --}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-header bg-white fw-semibold border-0 pt-3 pb-0">
                        <h6 class="mb-0">Pengaturan Wawancara</h6>
                        <small class="text-muted">Atur penilai, lokasi, dan detail interview</small>
                    </div>

                    <div class="card-body pt-3">

                        {{-- ALERT SLOT --}}
                        @if (count($previewSlot) < $kandidatBelumJadwal->count())
                            <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Slot tidak cukup untuk semua kandidat.
                            </div>
                        @endif

                        <form id="formAutoGenerate">
                            @csrf
                            {{-- PENILAI --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2">
                                    Tim Penilai
                                </label>
                                <div class="border rounded-3 p-3 bg-light"
                                    style="max-height:220px;overflow:auto; border:1px solid #e9ecef !important;">
                                    @foreach ($penilai as $p)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tim_penilai[]"
                                                value="{{ $p->idStaffUnit }}" id="p{{ $p->idStaffUnit }}">

                                            <label class="form-check-label" for="p{{ $p->idStaffUnit }}">
                                                {{ $p->namaPenilai }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <small class="text-danger d-none mt-1 d-block" id="errorPenilai">
                                    Pilih minimal 1 penilai
                                </small>
                            </div>
                            {{-- INPUT LOKASI & LINK --}}
                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Lokasi</label>
                                    <input class="form-control shadow-sm px-3 py-2" name="lokasi"
                                        placeholder="Contoh: Ruang Rapat Lt. 3" style="border-radius:10px;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Link Meeting</label>
                                    <input class="form-control shadow-sm px-3 py-2" name="link_wawancara"
                                        placeholder="https://meet.google.com/xxx" style="border-radius:10px;">
                                </div>

                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Tanggal Wawancara</label>
                                <input type="date" class="form-control shadow-sm px-3 py-2" name="tanggal_wawancara"
                                    style="border-radius:10px;">
                            </div>
                            {{-- KETERANGAN --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea class="form-control shadow-sm px-3 py-2" name="keterangan" rows="3"
                                    placeholder="Catatan tambahan untuk kandidat / penilai" style="border-radius:10px;"></textarea>
                            </div>
                            {{-- BUTTON --}}
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" id="btnGenerate" class="btn btn-primary px-4 shadow-sm"
                                    style="border-radius:10px;"
                                    {{ count($previewSlot) < $kandidatBelumJadwal->count() ? 'disabled' : '' }}>
                                    Generate {{ $kandidatBelumJadwal->count() }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="modalKonfirmasi">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Generate <b>{{ $kandidatBelumJadwal->count() }}</b> jadwal?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" id="btnConfirm">
                        Generate
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            let idLowongan = {{ $lowongan->id }};

            $('#btnGenerate').on('click', function() {

                let checked = $('input[name="tim_penilai[]"]:checked');

                if (checked.length === 0) {
                    $('#errorPenilai').removeClass('d-none');
                    return;
                }

                $('#errorPenilai').addClass('d-none');
                $('#modalKonfirmasi').modal('show');
            });

            $('#btnConfirm').on('click', function() {

                let btn = $(this);

                btn.prop('disabled', true).text('Generating...');

                $.ajax({
                    url: '/generatewawancara/autogenerate/' + idLowongan,
                    type: 'POST',
                    data: new FormData($('#formAutoGenerate')[0]),
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        alert(res.message);
                        if (res.status) {
                            window.location.href = '/wawancara/list-lowongan';
                        }
                        btn.prop('disabled', false).text('Generate');
                    },
                    error: function() {
                        alert('Error');
                        btn.prop('disabled', false).text('Generate');
                    }
                });

            });

        });
    </script>
@endpush

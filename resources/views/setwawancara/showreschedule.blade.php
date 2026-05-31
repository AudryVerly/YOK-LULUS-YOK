{{-- resources/views/setwawancara/reschedule.blade.php --}}
@extends('layouts.app')
@section('breadcrumb', 'Reschedule Penilai')

@section('content')
    <div class="container-fluid px-4 py-3">

        <div class="d-flex align-items-center gap-2 mb-4">
            <div>
                <h5 class="mb-0 fw-semibold">Reschedule Jadwal Wawancara</h5>
                <small class="text-muted">
                    {{ $jadwal->namaMahasiswa }} — {{ $jadwal->judulLowongan }}
                </small>
            </div>
        </div>

        <div class="row g-3">

            {{-- LEFT --}}
            <div class="col-lg-5">

                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white fw-semibold border-bottom">
                        <i class="bi bi-calendar-event text-primary me-1"></i> Detail Jadwal Lama
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">

                            <tr>
                                <td class="text-muted" style="width:40%">Kandidat</td>
                                <td><strong>{{ $jadwal->namaMahasiswa }}</strong></td>
                            </tr>

                            <tr>
                                <td class="text-muted">Lowongan</td>
                                <td>{{ $jadwal->judulLowongan }}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Tanggal</td>
                                <td>
                                    <strong class="text-decoration-line-through text-muted">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted">Waktu</td>
                                <td class="text-muted text-decoration-line-through">
                                    {{ substr($jadwal->mulai, 0, 5) }} - {{ substr($jadwal->selesai, 0, 5) }} WIB
                                </td>
                            </tr>

                            @if ($jadwal->lokasi)
                                <tr>
                                    <td class="text-muted">Lokasi</td>
                                    <td>{{ $jadwal->lokasi }}</td>
                                </tr>
                            @endif

                            @if ($jadwal->link)
                                <tr>
                                    <td class="text-muted">Link</td>
                                    <td>
                                        <a href="{{ $jadwal->link }}" target="_blank">
                                            {{ $jadwal->link }}
                                        </a>
                                    </td>
                                </tr>
                            @endif

                        </table>
                    </div>
                </div>

                {{-- STATUS PENILAI --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-semibold border-bottom">
                        <i class="bi bi-people text-primary me-1"></i> Status Penilai
                    </div>

                    <ul class="list-group list-group-flush">

                        @foreach ($penilaiAktif as $pa)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $pa->namaPenilai }}
                                    <small class="text-muted d-block">Tetap di jadwal lama</small>
                                </div>

                                @if ($pa->status == 'terjadwal')
                                    <span class="badge bg-success">Terima</span>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </li>
                        @endforeach

                        @foreach ($penilaiGagal as $pg)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $pg->namaPenilai }}
                                    <small class="text-muted d-block">Akan dijadwalkan ulang</small>
                                </div>
                                <span class="badge bg-danger">Cancel</span>
                            </li>
                        @endforeach

                    </ul>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-7">

                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-semibold border-bottom">
                        <i class="bi bi-arrow-repeat text-warning me-1"></i> Reschedule (Cancel Only)
                    </div>

                    <div class="card-body">

                        @if ($penilaiGagal->isEmpty())
                            <div class="alert alert-success">
                                Tidak ada penilai yang cancel.
                            </div>
                        @else
                            <div class="alert alert-info text-white">
                                Hanya penilai <b>yang cancel</b> yang akan dijadwalkan ulang.
                                Penilai yang sudah terima tetap di jadwal lama.
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Penilai yang Dijadwalkan Ulang
                                </label>

                                <div class="border rounded p-3">
                                    @foreach ($penilaiGagal as $pg)
                                        <div>
                                            <i class="bi bi-envelope"></i>
                                            {{ $pg->namaPenilai }}
                                            <span class="badge bg-warning text-dark float-end">
                                                Reschedule
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <form id="formReschedule">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Tanggal Baru
                                    </label>

                                    <input type="date" class="form-control shadow-sm px-3 py-2" name="tanggal_reschedule"
                                        id="tanggalReschedule" min="{{ now()->format('Y-m-d') }}">

                                    <div id="errorTanggal" class="text-danger small d-none">
                                        Tanggal wajib diisi
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('generatewawancara.listreschedule') }}" class="btn btn-secondary">
                                        Batal
                                    </a>

                                    <button type="button" id="btnReschedule" class="btn btn-warning">

                                        <span id="spinnerReschedule" class="spinner-border spinner-border-sm d-none"></span>

                                        Buat Jadwal Baru
                                    </button>
                                </div>

                            </form>

                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- TOAST --}}
    <div class="position-fixed bottom-0 end-0 m-3">
        <div id="toastMsg" class="toast">
            <div class="toast-body" id="toastBody"></div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {

            var idJadwal = {{ $jadwal->id }};

            $('#btnReschedule').on('click', function() {

                if (!$('#tanggalReschedule').val()) {
                    $('#errorTanggal').removeClass('d-none');
                    return;
                }

                let btn = $(this);
                let spinner = $('#spinnerReschedule');

                btn.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: '/generatewawancara/reshedule' + idJadwal,
                    type: 'POST',
                    data: new FormData($('#formReschedule')[0]),
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {

                        showToast(res.message, 'success');

                        if (res.status) {
                            setTimeout(() => {
                                window.location.href =
                                    '{{ route('generatewawancara.listreschedule') }}';
                            }, 1200);
                        }

                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    },

                    error: function(xhr) {

                        let msg = xhr.responseJSON?.message ?? 'Error';

                        showToast(msg, 'danger');

                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });

            });

            function showToast(msg, type) {
                $('#toastBody').text(msg);
                $('#toastMsg').attr('class', 'toast show text-bg-' + type);
                new bootstrap.Toast(document.getElementById('toastMsg')).show();
            }

        });
    </script>
@endpush

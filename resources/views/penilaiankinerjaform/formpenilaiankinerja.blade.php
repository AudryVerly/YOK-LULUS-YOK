@extends('layouts.app')
@section('breadcrumb', 'Form Penilaian Kinerja')

@section('content')
    <div class="container-fluid py-4">

        <div class="mb-4">
            <h4 class="fw-bold mb-1">Form Penilaian Kinerja</h4>
            <small class="text-muted">Berikan penilaian untuk kandidat berikut</small>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('kinerjaform.penilaiankinerja') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idMahasiswa" value="{{ $mahasiswa->id }}">
                    <input type="hidden" name="idLowongan" value="{{ $lowongan->id }}">
                    <input type="hidden" name="idUnit" value="{{ $lowongan->idUnit }}">

                    <div class="card border-0 shadow-sm rounded-4 mb-4" style="overflow: hidden;">

                        {{-- Header hitam --}}
                        <div class="card-header d-flex align-items-center justify-content-between"
                            style="background: #1a1a1a; padding: 0.75rem 1.25rem;">
                            <div>
                                <p class="mb-0 fw-semibold text-white" style="font-size:14px;">
                                    {{ $mahasiswa->namaMahasiswa }}
                                </p>
                                <p class="mb-0" style="font-size:11px; color:#aaa;">Mahasiswa</p>
                            </div>
                            <div class="text-end">
                                <p class="mb-0" style="font-size:12px; color:#aaa;">Lowongan</p>
                                <p class="mb-0 fw-semibold text-white" style="font-size:13px;">
                                    {{ $lowongan->judulLowongan }}
                                </p>
                            </div>
                        </div>

                        {{-- Body form --}}
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4">Penilaian Per Kriteria</h6>

                            @forelse($kriteria as $k)
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">{{ $k->nama }}</label>
                                    <input type="number" name="nilai[{{ $k->id }}]"
                                        class="form-control border rounded-3 px-3 py-2 @error('nilai.' . $k->id) is-invalid @enderror"
                                        min="0" max="100" step="0.01" placeholder="0 - 100"
                                        value="{{ old('nilai.' . $k->id) }}">
                                    @error('nilai.' . $k->id)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @empty
                                <div class="alert alert-warning">
                                    Belum ada kriteria penilaian untuk unit ini.
                                </div>
                            @endforelse
                            <hr>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Catatan</label>
                                <textarea name="catatan" class="form-control border rounded-3 px-3 py-2" rows="3">{{ old('catatan') }}</textarea>
                            </div>

                            <div class="alert alert-light border rounded-3 mb-4">
                                <small class="text-muted">Rata-rata nilai akan dihitung otomatis</small>
                                <div class="fw-bold fs-5" id="hasilRataRata">-</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success px-4 rounded-pill">
                                    Simpan Penilaian
                                </button>
                                <a href="{{ route('kinerjaform.listmahasiwa', $lowongan->idUnit) }}"
                                    class="btn btn-outline-secondary px-4 rounded-pill">
                                    Batal
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function hitungRataRata() {
                let total = 0,
                    count = 0;
                $('input[name^="nilai["]').each(function() {
                    const val = parseFloat($(this).val());
                    if (!isNaN(val)) {
                        total += val;
                        count++;
                    }
                });
                $('#hasilRataRata').text(
                    count > 0 ? 'Rata-rata: ' + (total / count).toFixed(2) : '-'
                );
            }

            $('input[name^="nilai["]').on('input', hitungRataRata);
            hitungRataRata();
        });
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
@endpush

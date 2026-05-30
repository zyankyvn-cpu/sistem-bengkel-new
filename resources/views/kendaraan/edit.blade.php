{{-- resources/views/kendaraan/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Kendaraan')
@section('breadcrumb', 'Data Master › Kendaraan › Edit')

@section('content')
<div class="container-fluid" style="max-width: 700px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <h5 class="mb-0 fw-bold">✏️ Edit Data Kendaraan</h5>
            <small class="text-muted">Data Master › Kendaraan › Edit</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-car-front me-2 text-primary"></i>
                Edit: <code>{{ $kendaraan->plat_nomor }}</code>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kendaraan.update', $kendaraan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Plat Nomor <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="plat_nomor"
                               class="form-control @error('plat_nomor') is-invalid @enderror"
                               value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}"
                               placeholder="D 1234 ABC">
                        @error('plat_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Jenis Kendaraan <span class="text-danger">*</span>
                        </label>
                        <select name="jenis_kendaraan"
                                class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($DaftarJenis as $nilai => $label)
                                <option value="{{ $nilai }}"
                                    {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == $nilai ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Nama Pemilik <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nama_pemilik"
                               class="form-control @error('nama_pemilik') is-invalid @enderror"
                               value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}"
                               placeholder="Nama lengkap pemilik">
                        @error('nama_pemilik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            No. Telepon <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="no_telepon"
                               class="form-control @error('no_telepon') is-invalid @enderror"
                               value="{{ old('no_telepon', $kendaraan->no_telepon) }}"
                               placeholder="08xx-xxxx-xxxx">
                        @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Merk <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="merk"
                               class="form-control @error('merk') is-invalid @enderror"
                               value="{{ old('merk', $kendaraan->merk) }}"
                               placeholder="Honda, Yamaha, Toyota...">
                        @error('merk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Model <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="model"
                               class="form-control @error('model') is-invalid @enderror"
                               value="{{ old('model', $kendaraan->model) }}"
                               placeholder="Beat, NMAX, Avanza...">
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tahun <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               name="tahun_kendaraan"
                               class="form-control @error('tahun_kendaraan') is-invalid @enderror"
                               value="{{ old('tahun_kendaraan', $kendaraan->tahun_kendaraan) }}"
                               placeholder="{{ date('Y') }}"
                               min="1990"
                               max="{{ date('Y') }}">
                        @error('tahun_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Warna <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="warna"
                               class="form-control @error('warna') is-invalid @enderror"
                               value="{{ old('warna', $kendaraan->warna) }}"
                               placeholder="Hitam, Putih, Merah...">
                        @error('warna')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Catatan tambahan (opsional)...">{{ old('catatan', $kendaraan->catatan) }}</textarea>
                    </div>

                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning fw-semibold">
                            <i class="bi bi-pencil-square"></i> Update Data
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@section('extra-js')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    let valid = true;

    // Validasi 1: Plat nomor tidak boleh kosong
    const PlatNomor = document.querySelector('input[name="plat_nomor"]');
    if (PlatNomor.value.trim() === '') {
        alert('Plat nomor tidak boleh kosong!');
        PlatNomor.focus();
        valid = false;
    }

    // Validasi 2: No telepon harus angka minimal 10 digit
    const NoTelepon = document.querySelector('input[name="no_telepon"]');
    if (!/^[0-9]{10,13}$/.test(NoTelepon.value.replace(/-/g, ''))) {
        alert('No telepon harus berupa angka 10-13 digit!');
        NoTelepon.focus();
        valid = false;
    }

    // Validasi 3: Tahun harus 4 digit dan masuk akal
    const Tahun = document.querySelector('input[name="tahun_kendaraan"]');
    if (Tahun.value.length !== 4 || Tahun.value < 1990 || Tahun.value > new Date().getFullYear()) {
        alert('Tahun kendaraan tidak valid!');
        Tahun.focus();
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>
@endsection
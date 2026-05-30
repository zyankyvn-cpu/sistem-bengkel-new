{{-- resources/views/kendaraan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <div>
            <h4 class="mb-0 fw-bold">➕ Tambah Data Kendaraan</h4>
            <small class="text-muted">Data Master › Kendaraan › Tambah</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('kendaraan.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plat Nomor <span class="text-danger">*</span></label>
                        <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror"
                            value="{{ old('plat_nomor') }}" placeholder="D 1234 ABC">
                        @error('plat_nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($DaftarJenis as $nilai => $label)
                                <option value="{{ $nilai }}" {{ old('jenis_kendaraan') == $nilai ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_kendaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror"
                            value="{{ old('nama_pemilik') }}" placeholder="Nama lengkap pemilik">
                        @error('nama_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Pemilik</label>
                        <input type="email" name="email_pemilik" class="form-control" 
                            value="{{ old('email_pemilik', $kendaraan->email_pemilik ?? '') }}"
                            placeholder="contoh@email.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror"
                            value="{{ old('no_telepon') }}" placeholder="08xx-xxxx-xxxx">
                        @error('no_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Merk <span class="text-danger">*</span></label>
                        <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror"
                            value="{{ old('merk') }}" placeholder="Honda, Yamaha, Toyota...">
                        @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Model <span class="text-danger">*</span></label>
                        <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                            value="{{ old('model') }}" placeholder="Beat, NMAX, Avanza...">
                        @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_kendaraan" class="form-control @error('tahun_kendaraan') is-invalid @enderror"
                            value="{{ old('tahun_kendaraan') }}" placeholder="{{ date('Y') }}" min="1990" max="{{ date('Y') }}">
                        @error('tahun_kendaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Warna <span class="text-danger">*</span></label>
                        <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror"
                            value="{{ old('warna') }}" placeholder="Hitam, Putih, Merah...">
                        @error('warna') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"
                            placeholder="Catatan tambahan (opsional)...">{{ old('catatan') }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
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

    const PlatNomor = document.querySelector('input[name="plat_nomor"]');
    if (PlatNomor.value.trim() === '') {
        e.preventDefault();
        Swal.fire({ icon: 'error', title: 'Oops!', text: 'Plat nomor tidak boleh kosong!' });
        return;
    }

    const NoTelepon = document.querySelector('input[name="no_telepon"]');
    if (!/^[0-9]{10,13}$/.test(NoTelepon.value.replace(/-/g, ''))) {
        e.preventDefault();
        Swal.fire({ icon: 'warning', title: 'Perhatian!', text: 'No telepon harus berupa angka 10-13 digit!' });
        return;
    }

    const Tahun = document.querySelector('input[name="tahun_kendaraan"]');
    if (Tahun.value.length !== 4 || Tahun.value < 1990 || Tahun.value > new Date().getFullYear()) {
        e.preventDefault();
        Swal.fire({ icon: 'warning', title: 'Perhatian!', text: 'Tahun kendaraan tidak valid!' });
        return;
    }
});
</script>
@endsection


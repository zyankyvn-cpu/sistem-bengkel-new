{{-- resources/views/sparepart/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Sparepart')
@section('breadcrumb', 'Data Master › Sparepart › Tambah')

@section('content')
<div class="container-fluid" style="max-width:750px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('sparepart.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <div>
            <h5 class="mb-0 fw-bold">➕ Tambah Data Sparepart</h5>
            <small class="text-muted">Data Master › Sparepart › Tambah</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-semibold"><i class="bi bi-gear me-2 text-primary"></i>Form Tambah Sparepart</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sparepart.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kode Sparepart <span class="text-danger">*</span></label>
                        <input type="text" name="kode_sparepart" class="form-control @error('kode_sparepart') is-invalid @enderror"
                            value="{{ old('kode_sparepart', $KodeBaru) }}" placeholder="SP-XXXX">
                        @error('kode_sparepart') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($DaftarJenis as $nilai => $label)
                                <option value="{{ $nilai }}" {{ old('jenis_kendaraan') == $nilai ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('jenis_kendaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama Sparepart <span class="text-danger">*</span></label>
                        <input type="text" name="nama_sparepart" class="form-control @error('nama_sparepart') is-invalid @enderror"
                            value="{{ old('nama_sparepart') }}" placeholder="Nama sparepart">
                        @error('nama_sparepart') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Merk</label>
                        <input type="text" name="merk" class="form-control"
                            value="{{ old('merk') }}" placeholder="Opsional">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($DaftarKategori as $kat)
                                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                        <select name="satuan" class="form-select @error('satuan') is-invalid @enderror">
                            @foreach($DaftarSatuan as $sat)
                                <option value="{{ $sat }}" {{ old('satuan') == $sat ? 'selected' : '' }}>{{ $sat }}</option>
                            @endforeach
                        </select>
                        @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stok Minimum <span class="text-danger">*</span></label>
                        <input type="number" name="stok_minimum" class="form-control @error('stok_minimum') is-invalid @enderror"
                            value="{{ old('stok_minimum', 5) }}" min="0">
                        @error('stok_minimum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                            value="{{ old('stok', 0) }}" min="0">
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Harga Beli <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror"
                                value="{{ old('harga_beli', 0) }}" min="0">
                        </div>
                        @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Harga Jual <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror"
                                value="{{ old('harga_jual', 0) }}" min="0">
                        </div>
                        @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Keterangan tambahan (opsional)...">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('sparepart.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- resources/views/sparepart/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Sparepart')
@section('breadcrumb', 'Data Master › Sparepart › Edit')

@section('content')
<div class="container-fluid" style="max-width:750px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('sparepart.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <div>
            <h5 class="mb-0 fw-bold">✏️ Edit Data Sparepart</h5>
            <small class="text-muted">Data Master › Sparepart › Edit</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-pencil-square me-2 text-warning"></i>
                Edit: <code>{{ $sparepart->kode_sparepart }}</code>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sparepart.update', $sparepart) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kode Sparepart <span class="text-danger">*</span></label>
                        <input type="text" name="kode_sparepart" class="form-control @error('kode_sparepart') is-invalid @enderror"
                            value="{{ old('kode_sparepart', $sparepart->kode_sparepart) }}">
                        @error('kode_sparepart') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                            @foreach($DaftarJenis as $nilai => $label)
                                <option value="{{ $nilai }}" {{ old('jenis_kendaraan', $sparepart->jenis_kendaraan) == $nilai ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('jenis_kendaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama Sparepart <span class="text-danger">*</span></label>
                        <input type="text" name="nama_sparepart" class="form-control @error('nama_sparepart') is-invalid @enderror"
                            value="{{ old('nama_sparepart', $sparepart->nama_sparepart) }}">
                        @error('nama_sparepart') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Merk</label>
                        <input type="text" name="merk" class="form-control"
                            value="{{ old('merk', $sparepart->merk) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                            @foreach($DaftarKategori as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $sparepart->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                        <select name="satuan" class="form-select">
                            @foreach($DaftarSatuan as $sat)
                                <option value="{{ $sat }}" {{ old('satuan', $sparepart->satuan) == $sat ? 'selected' : '' }}>{{ $sat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stok Minimum <span class="text-danger">*</span></label>
                        <input type="number" name="stok_minimum" class="form-control"
                            value="{{ old('stok_minimum', $sparepart->stok_minimum) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                            value="{{ old('stok', $sparepart->stok) }}" min="0">
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Harga Beli <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_beli" class="form-control"
                                value="{{ old('harga_beli', $sparepart->harga_beli) }}" min="0">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Harga Jual <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_jual" class="form-control"
                                value="{{ old('harga_jual', $sparepart->harga_jual) }}" min="0">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $sparepart->keterangan) }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('sparepart.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning fw-semibold">💾 Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
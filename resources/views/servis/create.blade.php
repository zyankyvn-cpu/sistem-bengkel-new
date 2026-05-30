{{-- resources/views/servis/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Servis')
@section('breadcrumb', 'Transaksi › Servis › Tambah')

@section('content')
<div class="container-fluid" style="max-width:700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('servis.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">➕ Tambah Data Servis</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('servis.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kode Servis <span class="text-danger">*</span></label>
                        <input type="text" name="kode_servis" class="form-control @error('kode_servis') is-invalid @enderror"
                            value="{{ old('kode_servis', $KodeBaru) }}">
                        @error('kode_servis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Servis <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_servis" class="form-control"
                            value="{{ old('tanggal_servis', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kendaraan <span class="text-danger">*</span></label>
                        <select name="kendaraan_id" class="form-select @error('kendaraan_id') is-invalid @enderror">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($DaftarKendaraan as $k)
                                <option value="{{ $k->id }}" {{ old('kendaraan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->plat_nomor }} — {{ $k->nama_pemilik }} ({{ $k->merk }} {{ $k->model }})
                                </option>
                            @endforeach
                        </select>
                        @error('kendaraan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mekanik <span class="text-danger">*</span></label>
                        <select name="mekanik_id" class="form-select @error('mekanik_id') is-invalid @enderror">
                            <option value="">-- Pilih Mekanik --</option>
                            @foreach($DaftarMekanik as $m)
                                <option value="{{ $m->id }}" {{ old('mekanik_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mekanik }} ({{ $m->spesialisasi }})
                                </option>
                            @endforeach
                        </select>
                        @error('mekanik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keluhan <span class="text-danger">*</span></label>
                        <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="2"
                            placeholder="Keluhan pelanggan...">{{ old('keluhan') }}</textarea>
                        @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Diagnosa</label>
                        <textarea name="diagnosa" class="form-control" rows="2"
                            placeholder="Hasil diagnosa mekanik (opsional)...">{{ old('diagnosa') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            @foreach($DaftarStatus as $nilai => $label)
                                <option value="{{ $nilai }}" {{ old('status', 'Antrian') == $nilai ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Biaya Jasa <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="biaya_jasa" class="form-control"
                                value="{{ old('biaya_jasa', 0) }}" min="0">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"
                            placeholder="Catatan tambahan (opsional)...">{{ old('catatan') }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('servis.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- resources/views/mekanik/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Mekanik')
@section('breadcrumb', 'Data Master › Mekanik › Edit')

@section('content')
<div class="container-fluid" style="max-width:650px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('mekanik.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">✏️ Edit Data Mekanik</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('mekanik.update', $mekanik) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kode Mekanik <span class="text-danger">*</span></label>
                        <input type="text" name="kode_mekanik" class="form-control @error('kode_mekanik') is-invalid @enderror"
                            value="{{ old('kode_mekanik', $mekanik->kode_mekanik) }}">
                        @error('kode_mekanik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            @foreach($DaftarStatus as $nilai => $label)
                                <option value="{{ $nilai }}" {{ old('status', $mekanik->status) == $nilai ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Nama Mekanik <span class="text-danger">*</span></label>
                        <input type="text" name="nama_mekanik" class="form-control @error('nama_mekanik') is-invalid @enderror"
                            value="{{ old('nama_mekanik', $mekanik->nama_mekanik) }}">
                        @error('nama_mekanik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon" class="form-control"
                            value="{{ old('no_telepon', $mekanik->no_telepon) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Spesialisasi <span class="text-danger">*</span></label>
                        <select name="spesialisasi" class="form-select">
                            @foreach($DaftarSpesialisasi as $s)
                                <option value="{{ $s }}" {{ old('spesialisasi', $mekanik->spesialisasi) == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Bergabung <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_bergabung" class="form-control"
                            value="{{ old('tanggal_bergabung', $mekanik->tanggal_bergabung->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pengalaman (Tahun)</label>
                        <input type="number" name="pengalaman_tahun" class="form-control"
                            value="{{ old('pengalaman_tahun', $mekanik->pengalaman_tahun) }}" min="0" max="50">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $mekanik->catatan) }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('mekanik.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning fw-semibold">💾 Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
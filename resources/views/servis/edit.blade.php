{{-- resources/views/servis/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Servis')
@section('breadcrumb', 'Transaksi › Servis › Edit')

@section('content')
<div class="container-fluid" style="max-width:700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('servis.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">✏️ Edit Data Servis</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('servis.update', $servis) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kode Servis <span class="text-danger">*</span></label>
                        <input type="text" name="kode_servis" class="form-control"
                            value="{{ old('kode_servis', $servis->kode_servis) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Servis <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_servis" class="form-control"
                            value="{{ old('tanggal_servis', $servis->tanggal_servis->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kendaraan <span class="text-danger">*</span></label>
                        <select name="kendaraan_id" class="form-select">
                            @foreach($DaftarKendaraan as $k)
                                <option value="{{ $k->id }}" {{ old('kendaraan_id', $servis->kendaraan_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->plat_nomor }} — {{ $k->nama_pemilik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mekanik <span class="text-danger">*</span></label>
                        <select name="mekanik_id" class="form-select">
                            @foreach($DaftarMekanik as $m)
                                <option value="{{ $m->id }}" {{ old('mekanik_id', $servis->mekanik_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mekanik }} ({{ $m->spesialisasi }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keluhan <span class="text-danger">*</span></label>
                        <textarea name="keluhan" class="form-control" rows="2">{{ old('keluhan', $servis->keluhan) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Diagnosa</label>
                        <textarea name="diagnosa" class="form-control" rows="2">{{ old('diagnosa', $servis->diagnosa) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            @foreach($DaftarStatus as $nilai => $label)
                                <option value="{{ $nilai }}" {{ old('status', $servis->status) == $nilai ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Biaya Jasa <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="biaya_jasa" class="form-control"
                                value="{{ old('biaya_jasa', $servis->biaya_jasa) }}" min="0">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $servis->catatan) }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('servis.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning fw-semibold">💾 Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
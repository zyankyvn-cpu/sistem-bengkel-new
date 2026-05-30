@extends('layouts.app')

@section('title', 'Edit Pembayaran')
@section('breadcrumb', 'Transaksi › Pembayaran › Edit')

@section('content')
<div class="container-fluid" style="max-width:700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">✏️ Edit Pembayaran</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pembayaran.update', $pembayaran) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control"
                            value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_bayar" class="form-control"
                                value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="kembalian" class="form-control"
                                value="{{ old('kembalian', $pembayaran->kembalian) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Metode Bayar</label>
                        <select name="metode_bayar" class="form-select">
                            @foreach($DaftarMetode as $m)
                                <option value="{{ $m }}" {{ old('metode_bayar', $pembayaran->metode_bayar) == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="Lunas" {{ $pembayaran->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Lunas" {{ $pembayaran->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $pembayaran->catatan) }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning fw-semibold">💾 Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
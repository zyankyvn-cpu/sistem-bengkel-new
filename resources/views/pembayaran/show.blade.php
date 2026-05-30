@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('breadcrumb', 'Transaksi › Pembayaran › Detail')

@section('content')
<div class="container-fluid" style="max-width:700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">👁️ Detail Pembayaran</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between">
            <h6 class="mb-0 fw-semibold">💳 <code>{{ $pembayaran->kode_pembayaran }}</code></h6>
            @if($pembayaran->status === 'Lunas')
                <span class="badge bg-success fs-6">Lunas</span>
            @else
                <span class="badge bg-danger fs-6">Belum Lunas</span>
            @endif
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="text-muted small">Kendaraan</div>
                    <div class="fw-semibold">{{ $pembayaran->servis->kendaraan->plat_nomor }}</div>
                    <small class="text-muted">{{ $pembayaran->servis->kendaraan->nama_pemilik }}</small>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Mekanik</div>
                    <div class="fw-semibold">{{ $pembayaran->servis->mekanik->nama_mekanik }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Tanggal Bayar</div>
                    <div class="fw-semibold">{{ $pembayaran->tanggal_bayar->format('d/m/Y') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Metode Bayar</div>
                    <div class="fw-semibold">{{ $pembayaran->metode_bayar }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">Biaya Jasa</div>
                    <div class="fw-semibold">Rp {{ number_format($pembayaran->total_biaya_jasa, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">Biaya Sparepart</div>
                    <div class="fw-semibold">Rp {{ number_format($pembayaran->total_biaya_sparepart, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">Total Bayar</div>
                    <div class="fw-semibold text-success fs-5">{{ $pembayaran->total_bayar_format }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Jumlah Bayar</div>
                    <div class="fw-semibold">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Kembalian</div>
                    <div class="fw-semibold">{{ $pembayaran->kembalian_format }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
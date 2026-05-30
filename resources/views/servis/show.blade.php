{{-- resources/views/servis/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Servis')
@section('breadcrumb', 'Transaksi › Servis › Detail')

@section('content')
<div class="container-fluid" style="max-width:700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('servis.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">👁️ Detail Servis</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold">🛠️ <code>{{ $servis->kode_servis }}</code></h6>
            @php $warna = match($servis->status) {
                'Antrian'    => 'warning',
                'Proses'     => 'info',
                'Selesai'    => 'success',
                'Dibatalkan' => 'danger',
                default      => 'secondary'
            }; @endphp
            <span class="badge bg-{{ $warna }} fs-6">{{ $servis->status }}</span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="text-muted small">Tanggal Servis</div>
                    <div class="fw-semibold">{{ $servis->tanggal_servis->format('d/m/Y') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Biaya Jasa</div>
                    <div class="fw-semibold text-success fs-5">{{ $servis->biaya_jasa_format }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Kendaraan</div>
                    <div class="fw-semibold">{{ $servis->kendaraan->plat_nomor }}</div>
                    <small class="text-muted">{{ $servis->kendaraan->merk }} {{ $servis->kendaraan->model }} — {{ $servis->kendaraan->nama_pemilik }}</small>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Mekanik</div>
                    <div class="fw-semibold">{{ $servis->mekanik->nama_mekanik }}</div>
                    <small class="text-muted">Spesialisasi: {{ $servis->mekanik->spesialisasi }}</small>
                </div>
                <div class="col-12">
                    <div class="text-muted small">Keluhan</div>
                    <div>{{ $servis->keluhan }}</div>
                </div>
                <div class="col-12">
                    <div class="text-muted small">Diagnosa</div>
                    <div>{{ $servis->diagnosa ?? '-' }}</div>
                </div>
                @if($servis->catatan)
                <div class="col-12">
                    <div class="text-muted small">Catatan</div>
                    <div>{{ $servis->catatan }}</div>
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer bg-white d-flex gap-2 justify-content-end">
            <a href="{{ route('servis.edit', $servis) }}" class="btn btn-warning">✏️ Edit</a>
        </div>
    </div>
</div>
@endsection
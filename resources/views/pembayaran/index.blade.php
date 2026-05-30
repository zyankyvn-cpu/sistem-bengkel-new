@extends('layouts.app')

@section('title', 'Transaksi Pembayaran')
@section('breadcrumb', 'Transaksi › Pembayaran')

@section('content')
<div class="container-fluid">

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            ✅ {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">💳 Transaksi Pembayaran</h4>
            <small class="text-muted">Transaksi › Pembayaran</small>
        </div>
        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">+ Tambah Pembayaran</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Total Transaksi</div>
                    <div class="fs-3 fw-bold text-primary">{{ $TotalPembayaran }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Lunas</div>
                    <div class="fs-3 fw-bold text-success">{{ $TotalLunas }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Belum Lunas</div>
                    <div class="fs-3 fw-bold text-danger">{{ $TotalBelumLunas }}</div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('pembayaran.index') }}" class="mb-3">
        <div class="d-flex gap-2">
            <input type="text" name="cari" class="form-control" style="max-width:300px;"
                placeholder="🔍 Cari kode / plat / pemilik..." value="{{ $Pencarian }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
            @if($Pencarian)
                <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Kendaraan</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($DataPembayaran as $index => $bayar)
                    <tr>
                        <td>{{ $DataPembayaran->firstItem() + $index }}</td>
                        <td><code>{{ $bayar->kode_pembayaran }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $bayar->servis->kendaraan->plat_nomor }}</div>
                            <small class="text-muted">{{ $bayar->servis->kendaraan->nama_pemilik }}</small>
                        </td>
                        <td>{{ $bayar->tanggal_bayar->format('d/m/Y') }}</td>
                        <td class="fw-semibold text-success">{{ $bayar->total_bayar_format }}</td>
                        <td><span class="badge bg-secondary">{{ $bayar->metode_bayar }}</span></td>
                        <td>
                            @if($bayar->status === 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td>
                            @hasanyrole('Admin|Kasir')
                            <div class="d-flex gap-1">
                                <a href="{{ route('pembayaran.show', $bayar) }}" class="btn btn-sm btn-outline-secondary">👁️</a>
                                <a href="{{ route('pembayaran.edit', $bayar) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                <form action="{{ route('pembayaran.destroy', $bayar) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                            </div>
                            @endhasanyrole
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $DataPembayaran->links() }}</div>
    </div>
</div>
@endsection
{{-- resources/views/sparepart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Sparepart')
@section('breadcrumb', 'Data Master › Sparepart')

@section('content')
<div class="container-fluid">

    {{-- Alert --}}
    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">🔩 Data Sparepart</h4>
            <small class="text-muted">Data Master › Sparepart</small>
        </div>
        <a href="{{ route('sparepart.create') }}" class="btn btn-primary">
            + Tambah Sparepart
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Total Sparepart</div>
                    <div class="fs-3 fw-bold text-primary">{{ $TotalSparepart }}</div>
                    <div class="text-muted small">Jenis terdaftar</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Stok Menipis</div>
                    <div class="fs-3 fw-bold text-warning">{{ $StokMenipis }}</div>
                    <div class="text-muted small">Perlu restock segera</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Stok Habis</div>
                    <div class="fs-3 fw-bold text-danger">{{ $StokHabis }}</div>
                    <div class="text-muted small">Tidak tersedia</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('sparepart.index') }}" class="mb-3">
        <div class="d-flex gap-2 flex-wrap">
            <input type="text" name="cari" class="form-control" style="max-width:300px;"
                placeholder="🔍 Cari kode / nama / kategori..."
                value="{{ $Pencarian }}">
            <select name="jenis" class="form-select" style="max-width:160px;">
                <option value="">Semua Jenis</option>
                <option value="Motor" {{ $FilterJenis == 'Motor' ? 'selected' : '' }}>Motor</option>
                <option value="Mobil" {{ $FilterJenis == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                <option value="Semua" {{ $FilterJenis == 'Semua' ? 'selected' : '' }}>Semua</option>
            </select>
            <button class="btn btn-outline-secondary" type="submit">Filter</button>
            @if($Pencarian || $FilterJenis)
                <a href="{{ route('sparepart.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Sparepart</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($DataSparepart as $index => $sparepart)
                    <tr>
                        <td>{{ $DataSparepart->firstItem() + $index }}</td>
                        <td><code>{{ $sparepart->kode_sparepart }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $sparepart->nama_sparepart }}</div>
                            @if($sparepart->merk)
                                <small class="text-muted">{{ $sparepart->merk }}</small>
                            @endif
                        </td>
                        <td>{{ $sparepart->kategori }}</td>
                        <td>
                            @if($sparepart->jenis_kendaraan === 'Motor')
                                <span class="badge bg-warning text-dark">🏍️ Motor</span>
                            @elseif($sparepart->jenis_kendaraan === 'Mobil')
                                <span class="badge bg-primary">🚙 Mobil</span>
                            @else
                                <span class="badge bg-secondary">🔧 Semua</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold">{{ $sparepart->stok }}</span>
                            <small class="text-muted">{{ $sparepart->satuan }}</small>
                        </td>
                        <td>{{ $sparepart->harga_jual_format }}</td>
                        <td>
                            @if($sparepart->status_stok === 'habis')
                                <span class="badge bg-danger">Habis</span>
                            @elseif($sparepart->status_stok === 'menipis')
                                <span class="badge bg-warning text-dark">Menipis</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                       <td>
                        @role('Admin')
                        <div class="d-flex gap-1">
                            <a href="{{ route('sparepart.edit', $sparepart) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                            <form action="{{ route('sparepart.destroy', $sparepart) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">🗑️</button>
                            </form>
                        </div>
                        @endrole
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Belum ada data sparepart.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $DataSparepart->links() }}
        </div>
    </div>
</div>
@endsection
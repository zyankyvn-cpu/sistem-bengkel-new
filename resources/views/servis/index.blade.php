{{-- resources/views/servis/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Servis')
@section('breadcrumb', 'Transaksi › Servis')

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
            <h4 class="mb-0 fw-bold">🛠️ Data Servis</h4>
            <small class="text-muted">Transaksi › Servis</small>
        </div>
        <a href="{{ route('servis.create') }}" class="btn btn-primary">+ Tambah Servis</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Total Servis</div>
                    <div class="fs-3 fw-bold text-primary">{{ $TotalServis }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Antrian</div>
                    <div class="fs-3 fw-bold text-warning">{{ $Antrian }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Sedang Proses</div>
                    <div class="fs-3 fw-bold text-info">{{ $Proses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Selesai</div>
                    <div class="fs-3 fw-bold text-success">{{ $Selesai }}</div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('servis.index') }}" class="mb-3">
        <div class="d-flex gap-2 flex-wrap">
            <input type="text" name="cari" class="form-control" style="max-width:280px;"
                placeholder="🔍 Cari kode / plat / pemilik..." value="{{ $Pencarian }}">
            <select name="status" class="form-select" style="max-width:160px;">
                <option value="">Semua Status</option>
                @foreach(['Antrian','Proses','Selesai','Dibatalkan'] as $s)
                    <option value="{{ $s }}" {{ $FilterStatus == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-secondary" type="submit">Filter</button>
            @if($Pencarian || $FilterStatus)
                <a href="{{ route('servis.index') }}" class="btn btn-outline-danger">Reset</a>
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
                        <th>Pemilik</th>
                        <th>Mekanik</th>
                        <th>Tanggal</th>
                        <th>Keluhan</th>
                        <th>Biaya Jasa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($DataServis as $index => $servis)
                    <tr>
                        <td>{{ $DataServis->firstItem() + $index }}</td>
                        <td><code>{{ $servis->kode_servis }}</code></td>
                        <td>
                            <span class="fw-semibold">{{ $servis->kendaraan->plat_nomor }}</span><br>
                            <small class="text-muted">{{ $servis->kendaraan->merk }} {{ $servis->kendaraan->model }}</small>
                        </td>
                        <td>{{ $servis->kendaraan->nama_pemilik }}</td>
                        <td>{{ $servis->mekanik->nama_mekanik }}</td>
                        <td>{{ $servis->tanggal_servis->format('d/m/Y') }}</td>
                        <td style="max-width:180px;">
                            <span class="text-truncate d-block" style="max-width:180px;" title="{{ $servis->keluhan }}">
                                {{ $servis->keluhan }}
                            </span>
                        </td>
                        <td>{{ $servis->biaya_jasa_format }}</td>
                        <td>
                            @php $warna = match($servis->status) {
                                'Antrian'    => 'warning',
                                'Proses'     => 'info',
                                'Selesai'    => 'success',
                                'Dibatalkan' => 'danger',
                                default      => 'secondary'
                            }; @endphp
                            <span class="badge bg-{{ $warna }}">{{ $servis->status }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('servis.show', $servis) }}" class="btn btn-sm btn-outline-secondary">👁️</a>
                                <a href="{{ route('servis.edit', $servis) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                <form action="{{ route('servis.destroy', $servis) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus data servis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">Belum ada data servis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $DataServis->links() }}</div>
    </div>
</div>
@endsection
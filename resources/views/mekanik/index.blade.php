{{-- resources/views/mekanik/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Mekanik')
@section('breadcrumb', 'Data Master › Mekanik')

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
            <h4 class="mb-0 fw-bold">👨‍🔧 Data Mekanik</h4>
            <small class="text-muted">Data Master › Mekanik</small>
        </div>
        <a href="{{ route('mekanik.create') }}" class="btn btn-primary">+ Tambah Mekanik</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Total Mekanik</div>
                    <div class="fs-3 fw-bold text-primary">{{ $TotalMekanik }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Mekanik Aktif</div>
                    <div class="fs-3 fw-bold text-success">{{ $MekanikAktif }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Tidak Aktif</div>
                    <div class="fs-3 fw-bold text-danger">{{ $TotalMekanik - $MekanikAktif }}</div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('mekanik.index') }}" class="mb-3">
        <div class="d-flex gap-2">
            <input type="text" name="cari" class="form-control" style="max-width:300px;"
                placeholder="🔍 Cari kode / nama mekanik..." value="{{ $Pencarian }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
            @if($Pencarian)
                <a href="{{ route('mekanik.index') }}" class="btn btn-outline-danger">Reset</a>
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
                        <th>Nama Mekanik</th>
                        <th>No. Telepon</th>
                        <th>Spesialisasi</th>
                        <th>Pengalaman</th>
                        <th>Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($DataMekanik as $index => $mekanik)
                    <tr>
                        <td>{{ $DataMekanik->firstItem() + $index }}</td>
                        <td><code>{{ $mekanik->kode_mekanik }}</code></td>
                        <td class="fw-semibold">{{ $mekanik->nama_mekanik }}</td>
                        <td>{{ $mekanik->no_telepon }}</td>
                        <td>
                            @if($mekanik->spesialisasi === 'Motor')
                                <span class="badge bg-warning text-dark">🏍️ Motor</span>
                            @elseif($mekanik->spesialisasi === 'Mobil')
                                <span class="badge bg-primary">🚙 Mobil</span>
                            @else
                                <span class="badge bg-secondary">🔧 Keduanya</span>
                            @endif
                        </td>
                        <td>{{ $mekanik->pengalaman_tahun }} tahun</td>
                        <td>{{ $mekanik->tanggal_bergabung->format('d/m/Y') }}</td>
                        <td>
                            @if($mekanik->status === 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @role('Admin')
                            <div class="d-flex gap-1">
                                <a href="{{ route('mekanik.edit', $mekanik) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                <form action="{{ route('mekanik.destroy', $mekanik) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                            </div>
                            @endrole
                        </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Belum ada data mekanik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $DataMekanik->links() }}</div>
    </div>
</div>
@endsection
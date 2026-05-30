{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
<div class="container-fluid py-4">

    {{-- Alert Sukses --}}
    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">🚗 Data Kendaraan</h4>
            <small class="text-muted">Data Master › Kendaraan</small>
        </div>
        <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
            + Tambah Kendaraan
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('kendaraan.index') }}" class="mb-3">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="cari" class="form-control"
                placeholder="Cari plat / pemilik / merk..."
                value="{{ $Pencarian }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
            @if($Pencarian)
                <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Plat Nomor</th>
                        <th>Nama Pemilik</th>
                        <th>Jenis</th>
                        <th>Merk / Model</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($DataKendaraan as $index => $kendaraan)
                    <tr>
                        <td>{{ $DataKendaraan->firstItem() + $index }}</td>
                        <td><code>{{ $kendaraan->plat_nomor }}</code></td>
                        <td>{{ $kendaraan->nama_pemilik }}</td>
                        <td>
                            @if($kendaraan->jenis_kendaraan === 'Motor')
                                <span class="badge bg-warning text-dark">🏍️ Motor</span>
                            @else
                                <span class="badge bg-primary">🚙 Mobil</span>
                            @endif
                        </td>
                        <td>{{ $kendaraan->merk }} / {{ $kendaraan->model }}</td>
                        <td>{{ $kendaraan->tahun_kendaraan }}</td>
                        <td>{{ $kendaraan->warna }}</td>
                        <td>{{ $kendaraan->no_telepon }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                @role('Admin')
                                <a href="{{ route('kendaraan.edit', $kendaraan) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                <form action="{{ route('kendaraan.destroy', $kendaraan) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                                @endrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Belum ada data kendaraan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $DataKendaraan->links() }}
        </div>
    </div>
</div>
@endsection

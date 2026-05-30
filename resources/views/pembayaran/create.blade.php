@extends('layouts.app')

@section('title', 'Tambah Pembayaran')
@section('breadcrumb', 'Transaksi › Pembayaran › Tambah')

@section('content')
<div class="container-fluid" style="max-width:700px;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <h5 class="mb-0 fw-bold">➕ Tambah Pembayaran</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pembayaran.store') }}" method="POST" id="FormPembayaran">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kode Pembayaran <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pembayaran" class="form-control @error('kode_pembayaran') is-invalid @enderror"
                            value="{{ old('kode_pembayaran', $KodeBaru) }}">
                        @error('kode_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Bayar <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_bayar" class="form-control"
                            value="{{ old('tanggal_bayar', date('Y-m-d')) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Servis <span class="text-danger">*</span></label>
                        <select name="servis_id" class="form-select @error('servis_id') is-invalid @enderror" id="SelectServis">
                            <option value="">-- Pilih Servis --</option>
                            @foreach($DaftarServis as $s)
                                <option value="{{ $s->id }}"
                                    data-biaya="{{ $s->biaya_jasa }}"
                                    {{ old('servis_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->kode_servis }} — {{ $s->kendaraan->plat_nomor }} ({{ $s->kendaraan->nama_pemilik }})
                                </option>
                            @endforeach
                        </select>
                        @error('servis_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Biaya Jasa</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="total_biaya_jasa" id="BiayaJasa" class="form-control" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Biaya Sparepart</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="total_biaya_sparepart" id="BiayaSparepart" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Total Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="total_bayar" id="TotalBayar" class="form-control fw-bold" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_bayar" id="JumlahBayar" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="kembalian" id="Kembalian" class="form-control" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Metode Bayar <span class="text-danger">*</span></label>
                        <select name="metode_bayar" class="form-select">
                            @foreach($DaftarMetode as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    // Auto hitung saat pilih servis
    document.getElementById('SelectServis').addEventListener('change', function() {
        const BiayaJasa = this.options[this.selectedIndex].dataset.biaya || 0;
        document.getElementById('BiayaJasa').value = BiayaJasa;
        hitungTotal();
    });

    // Auto hitung saat isi biaya sparepart
    document.getElementById('BiayaSparepart').addEventListener('input', hitungTotal);

    // Auto hitung kembalian
    document.getElementById('JumlahBayar').addEventListener('input', function() {
        const Total   = parseInt(document.getElementById('TotalBayar').value) || 0;
        const Bayar   = parseInt(this.value) || 0;
        document.getElementById('Kembalian').value = Math.max(0, Bayar - Total);
    });

    function hitungTotal() {
        const Jasa      = parseInt(document.getElementById('BiayaJasa').value) || 0;
        const Sparepart = parseInt(document.getElementById('BiayaSparepart').value) || 0;
        document.getElementById('TotalBayar').value = Jasa + Sparepart;
    }

    // Validasi JS
    document.getElementById('FormPembayaran').addEventListener('submit', function(e) {
        const Servis = document.getElementById('SelectServis').value;
        if (!Servis) {
            e.preventDefault();
            Swal.fire({ icon: 'error', title: 'Oops!', text: 'Pilih servis terlebih dahulu!' });
            return;
        }
        const Bayar = parseInt(document.getElementById('JumlahBayar').value) || 0;
        const Total = parseInt(document.getElementById('TotalBayar').value) || 0;
        if (Bayar < Total) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Perhatian!', text: 'Jumlah bayar kurang dari total!' });
            return;
        }
    });
</script>
@endsection
@endsection
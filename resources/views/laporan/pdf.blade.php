<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1e293b; background: #fff; }

    .header {
        background: #0f172a;
        color: #fff;
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }
    .header h1 { font-size: 14px; font-weight: bold; }
    .header small { font-size: 9px; color: #94a3b8; }
    .header .period { font-size: 10px; color: #f59e0b; }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 14px;
    }
    .summary-box {
        border: 0.5px solid #e2e8f0;
        border-radius: 6px;
        padding: 8px 10px;
        border-left: 3px solid #f59e0b;
    }
    .summary-label { font-size: 8.5px; color: #64748b; margin-bottom: 3px; }
    .summary-value { font-size: 11px; font-weight: bold; color: #0f172a; }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #0f172a; color: #fff; }
    thead th { padding: 7px 8px; text-align: left; font-size: 8.5px; font-weight: 600; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody td { padding: 5px 8px; font-size: 9px; border-bottom: 0.5px solid #f1f5f9; }
    tfoot tr { background: #f1f5f9; }
    tfoot td { padding: 6px 8px; font-size: 9.5px; font-weight: bold; }

    .badge {
        display: inline-block;
        padding: 1px 6px;
        border-radius: 10px;
        font-size: 8px;
        font-weight: 600;
    }
    .lunas    { background: #dcfce7; color: #166534; }
    .belum    { background: #fee2e2; color: #991b1b; }
    .cicilan  { background: #e0f2fe; color: #0369a1; }

    .footer {
        margin-top: 14px;
        font-size: 8.5px;
        color: #94a3b8;
        text-align: right;
        border-top: 0.5px solid #e2e8f0;
        padding-top: 6px;
    }
</style>
</head>
<body>

<div class="header">
    <div>
        <h1>Laporan Penjualan</h1>
        <small>Sistem Informasi Bengkel Motor &amp; Mobil</small>
    </div>
    <div style="text-align:right;">
        <div class="period">{{ $periodeLabel }}</div>
        <small>Dicetak: {{ now()->format('d/m/Y H:i') }}</small>
    </div>
</div>

<div class="summary-grid">
    <div class="summary-box">
        <div class="summary-label">Total Pendapatan</div>
        <div class="summary-value">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-box" style="border-left-color:#f59e0b;">
        <div class="summary-label">Pendapatan Jasa</div>
        <div class="summary-value">Rp {{ number_format($summary['total_biaya_jasa'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-box" style="border-left-color:#3b82f6;">
        <div class="summary-label">Pendapatan Sparepart</div>
        <div class="summary-value">Rp {{ number_format($summary['total_biaya_sparepart'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-box" style="border-left-color:#8b5cf6;">
        <div class="summary-label">Jumlah Transaksi</div>
        <div class="summary-value">{{ number_format($summary['jumlah_transaksi']) }} transaksi</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Pembayaran</th>
            <th>Tanggal</th>
            <th>Plat / Pemilik</th>
            <th>Mekanik</th>
            <th>Biaya Jasa</th>
            <th>Sparepart</th>
            <th>Total Bayar</th>
            <th>Metode</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $i => $t)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $t->kode_pembayaran }}</td>
            <td>{{ \Carbon\Carbon::parse($t->tanggal_bayar)->format('d/m/Y') }}</td>
            <td>
                {{ $t->servis->kendaraan->plat_nomor ?? '-' }}<br>
                <span style="color:#94a3b8;">{{ $t->servis->kendaraan->nama_pemilik ?? '-' }}</span>
            </td>
            <td>{{ $t->servis->mekanik->nama_mekanik ?? '-' }}</td>
            <td>Rp {{ number_format($t->biaya_jasa, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($t->biaya_sparepart, 0, ',', '.') }}</td>
            <td><strong>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong></td>
            <td>{{ $t->metode_bayar }}</td>
            <td>
                @php
                    $cls = match($t->status) {
                        'Lunas'       => 'lunas',
                        'Belum Lunas' => 'belum',
                        'Cicilan'     => 'cicilan',
                        default       => 'lunas'
                    };
                @endphp
                <span class="badge {{ $cls }}">{{ $t->status }}</span>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right;">TOTAL</td>
            <td>Rp {{ number_format($transaksi->sum('biaya_jasa'), 0, ',', '.') }}</td>
            <td>Rp {{ number_format($transaksi->sum('biaya_sparepart'), 0, ',', '.') }}</td>
            <td>Rp {{ number_format($transaksi->sum('total_bayar'), 0, ',', '.') }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    Laporan ini dibuat otomatis oleh Sistem Informasi Bengkel — {{ now()->format('d F Y H:i') }}
</div>

</body>
</html>
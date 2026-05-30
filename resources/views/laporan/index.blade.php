@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('breadcrumb', 'Laporan › Penjualan')

@section('extra-css')
<style>
    /* ── Filter Bar ── */
    .filter-bar {
        background: #fff;
        border: 0.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-bar label {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
    }
    .filter-bar .form-select,
    .filter-bar .form-control {
        font-size: 12.5px;
        border: 0.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 6px 10px;
        color: #374151;
        background: #f8fafc;
        height: 34px;
        min-width: 0;
    }
    .filter-bar .form-select:focus,
    .filter-bar .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245,158,11,.12);
        outline: none;
        background: #fff;
    }
    .btn-filter {
        height: 34px;
        padding: 0 14px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex; align-items: center; gap: 6px;
        transition: background .15s, transform .1s;
    }
    .btn-filter:active { transform: scale(.97); }
    .btn-filter.primary { background: #f59e0b; color: #fff; }
    .btn-filter.primary:hover { background: #d97706; }
    .btn-filter.secondary { background: #f1f5f9; color: #374151; border: 0.5px solid #e2e8f0; }
    .btn-filter.secondary:hover { background: #e2e8f0; }
    .btn-filter.export-pdf    { background: #ef4444; color: #fff; }
    .btn-filter.export-pdf:hover { background: #dc2626; }
    .btn-filter.export-excel  { background: #22c55e; color: #fff; }
    .btn-filter.export-excel:hover { background: #16a34a; }

    /* ── Summary Cards (reuse stat-card style) ── */
    .stat-card {
        background: #fff;
        border: 0.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-left: 3px solid transparent;
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.09); }
    .stat-card.blue  { border-left-color: #3b82f6; }
    .stat-card.green { border-left-color: #22c55e; }
    .stat-card.amber { border-left-color: #f59e0b; }
    .stat-card.purple { border-left-color: #8b5cf6; }

    .stat-icon {
        width: 46px; height: 46px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 20px;
    }
    .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon.green  { background: #f0fdf4; color: #16a34a; }
    .stat-icon.amber  { background: #fffbeb; color: #d97706; }
    .stat-icon.purple { background: #f5f3ff; color: #7c3aed; }

    .stat-label { font-size: 11px; color: #64748b; margin-bottom: 3px; }
    .stat-value { font-size: 20px; font-weight: 500; color: #0f172a; line-height: 1.2; }
    .stat-value.sm { font-size: 15px; }
    .stat-sub   { font-size: 10.5px; color: #94a3b8; margin-top: 3px; }

    /* ── Dash Card ── */
    .dash-card {
        background: #fff;
        border: 0.5px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .dash-card-head {
        padding: 12px 16px;
        border-bottom: 0.5px solid #e2e8f0;
        display: flex; align-items: center; gap: 8px;
    }
    .dash-card-head span { font-size: 13px; font-weight: 500; color: #0f172a; }
    .dash-card-head i    { font-size: 15px; color: #94a3b8; }
    .dash-card-body { padding: 16px; }

    /* ── Tabel Laporan ── */
    .laporan-table { width: 100%; border-collapse: collapse; }
    .laporan-table th {
        font-size: 11px; color: #64748b; font-weight: 500;
        padding: 8px 14px; text-align: left;
        border-bottom: 0.5px solid #e2e8f0;
        background: #f8fafc;
        white-space: nowrap;
    }
    .laporan-table td {
        font-size: 12.5px; color: #374151;
        padding: 9px 14px;
        border-bottom: 0.5px solid #f1f5f9;
        vertical-align: middle;
    }
    .laporan-table tbody tr:last-child td { border-bottom: none; }
    .laporan-table tbody tr {
        transition: background .15s ease, box-shadow .15s ease;
    }
    .laporan-table tbody tr:hover {
        background: #f0f9ff !important;
        box-shadow: inset 3px 0 0 #3b82f6;
    }

    .kode-pay  { font-weight: 500; color: #0f172a; font-size: 12px; }
    .sub-text  { font-size: 10.5px; color: #94a3b8; }
    .plat-nomor { font-weight: 500; color: #0f172a; }

    /* Badge */
    .badge-status {
        font-size: 10px; font-weight: 500;
        padding: 3px 9px; border-radius: 20px;
        display: inline-block;
    }
    .badge-lunas   { background: #dcfce7; color: #166534; }
    .badge-belum   { background: #fee2e2; color: #991b1b; }
    .badge-cicilan { background: #e0f2fe; color: #0369a1; }
    .badge-tunai   { background: #f0fdf4; color: #166534; }
    .badge-transfer { background: #eff6ff; color: #1d4ed8; }
    .badge-debit   { background: #f5f3ff; color: #5b21b6; }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 12px 16px;
        border-top: 0.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }
    .pagination-info { font-size: 11.5px; color: #64748b; }
    .pagination .page-link {
        font-size: 12px;
        padding: 4px 10px;
        border-color: #e2e8f0;
        color: #374151;
        border-radius: 6px !important;
        margin: 0 1px;
    }
    .pagination .page-link:hover { background: #f1f5f9; border-color: #e2e8f0; color: #0f172a; }
    .pagination .page-item.active .page-link { background: #f59e0b; border-color: #f59e0b; color: #fff; }
    .pagination .page-item.disabled .page-link { color: #cbd5e1; }

    /* ── Empty state ── */
    .empty-state {
        padding: 40px 16px;
        text-align: center;
        color: #94a3b8; font-size: 13px;
    }
    .empty-state i { font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1; }

    /* ── Metode badge pill ── */
    .metode-pill {
        font-size: 10px; font-weight: 500;
        padding: 2px 8px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 4px;
    }

    /* ── Period indicator ── */
    .period-info {
        font-size: 11px; color: #64748b;
        background: #f8fafc;
        border: 0.5px solid #e2e8f0;
        border-radius: 7px;
        padding: 4px 10px;
        display: inline-flex; align-items: center; gap: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- ── Filter Bar ── --}}
    <form method="GET" action="{{ route('laporan.index') }}" id="filterForm">
    <div class="filter-bar mb-4">
        <i class="ti ti-filter" style="color:#94a3b8; font-size:15px; flex-shrink:0;"></i>

        <label>Periode</label>
        <select name="periode" class="form-select" style="width:130px;" onchange="toggleCustomDate(this.value)">
            <option value="harian"   {{ $periode === 'harian'   ? 'selected' : '' }}>Harian</option>
            <option value="mingguan" {{ $periode === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
            <option value="bulanan"  {{ $periode === 'bulanan'  ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan"  {{ $periode === 'tahunan'  ? 'selected' : '' }}>Tahunan</option>
            <option value="custom"   {{ $periode === 'custom'   ? 'selected' : '' }}>Custom</option>
        </select>

        <div id="customDateWrap" style="display:{{ $periode === 'custom' ? 'flex' : 'none' }}; align-items:center; gap:6px;">
            <label>Dari</label>
            <input type="date" name="dari" class="form-control" style="width:140px;"
                   value="{{ $dari ?? '' }}">
            <label>s/d</label>
            <input type="date" name="sampai" class="form-control" style="width:140px;"
                   value="{{ $sampai ?? '' }}">
        </div>

        <label>Metode</label>
        <select name="metode" class="form-select" style="width:120px;">
            <option value="">Semua</option>
            <option value="Tunai"    {{ ($metode ?? '') === 'Tunai'    ? 'selected' : '' }}>Tunai</option>
            <option value="Transfer" {{ ($metode ?? '') === 'Transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="Debit"    {{ ($metode ?? '') === 'Debit'    ? 'selected' : '' }}>Debit</option>
        </select>

        <label>Status</label>
        <select name="status" class="form-select" style="width:110px;">
            <option value="">Semua</option>
            <option value="Lunas"   {{ ($statusFilter ?? '') === 'Lunas'   ? 'selected' : '' }}>Lunas</option>
            <option value="Belum Lunas" {{ ($statusFilter ?? '') === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
            <option value="Cicilan" {{ ($statusFilter ?? '') === 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
        </select>

        <button type="submit" class="btn-filter primary">
            <i class="ti ti-search" style="font-size:13px;"></i> Tampilkan
        </button>
        <a href="{{ route('laporan.index') }}" class="btn-filter secondary">
            <i class="ti ti-refresh" style="font-size:13px;"></i> Reset
        </a>

        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('laporan.export.pdf', request()->query()) }}"
               class="btn-filter export-pdf" target="_blank">
                <i class="ti ti-file-type-pdf" style="font-size:13px;"></i> Export PDF
            </a>
            <a href="{{ route('laporan.export.excel', request()->query()) }}"
               class="btn-filter export-excel">
                <i class="ti ti-file-spreadsheet" style="font-size:13px;"></i> Export Excel
            </a>
        </div>
    </div>
    </form>

    {{-- ── Period Indicator ── --}}
    <div class="mb-3">
        <span class="period-info">
            <i class="ti ti-calendar" style="font-size:12px;"></i>
            {!! $periodeLabel !!}
        </span>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="ti ti-cash"></i></div>
                <div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value sm">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
                    <div class="stat-sub">{{ $summary['jumlah_transaksi'] }} transaksi</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card amber">
                <div class="stat-icon amber"><i class="ti ti-tool"></i></div>
                <div>
                    <div class="stat-label">Pendapatan Jasa</div>
                    <div class="stat-value sm">Rp {{ number_format($summary['total_biaya_jasa'], 0, ',', '.') }}</div>
                    <div class="stat-sub">Biaya servis</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="ti ti-settings"></i></div>
                <div>
                    <div class="stat-label">Pendapatan Sparepart</div>
                    <div class="stat-value sm">Rp {{ number_format($summary['total_biaya_sparepart'], 0, ',', '.') }}</div>
                    <div class="stat-sub">Penjualan part</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card purple">
                <div class="stat-icon purple"><i class="ti ti-receipt"></i></div>
                <div>
                    <div class="stat-label">Rata-rata / Transaksi</div>
                    <div class="stat-value sm">Rp {{ $summary['jumlah_transaksi'] > 0 ? number_format($summary['total_pendapatan'] / $summary['jumlah_transaksi'], 0, ',', '.') : '0' }}</div>
                    <div class="stat-sub">Per nota</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Grafik ── --}}
    <div class="row g-3 mb-4">
        {{-- Grafik Pendapatan per Periode --}}
        <div class="col-md-8">
            <div class="dash-card h-100">
                <div class="dash-card-head">
                    <i class="ti ti-chart-bar"></i>
                    <span>Grafik Pendapatan</span>
                    <span style="margin-left:auto; font-size:10.5px; color:#94a3b8;">{{ $periodeLabel }}</span>
                </div>
                <div class="dash-card-body">
                    <div style="position:relative; height:200px;">
                        <canvas id="grafikPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Donut Metode Bayar --}}
        <div class="col-md-4">
            <div class="dash-card h-100">
                <div class="dash-card-head">
                    <i class="ti ti-chart-donut"></i>
                    <span>Metode Pembayaran</span>
                </div>
                <div class="dash-card-body">
                    <div style="position:relative; height:160px;">
                        <canvas id="grafikMetode"></canvas>
                    </div>
                    <div class="mt-2" id="legendMetode"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Tabel Transaksi ── --}}
    <div class="dash-card">
        <div class="dash-card-head justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-list"></i>
                <span>Detail Transaksi</span>
            </div>
            <span style="font-size:11px; color:#94a3b8;">
                {{ $transaksi->total() }} data ditemukan
            </span>
        </div>

        <div class="table-responsive">
        <table class="laporan-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Kendaraan</th>
                    <th>Mekanik</th>
                    <th>Biaya Jasa</th>
                    <th>Biaya Sparepart</th>
                    <th>Total Bayar</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $i => $t)
                <tr>
                    <td style="color:#94a3b8; font-size:11px;">{{ $transaksi->firstItem() + $i }}</td>
                    <td>
                        <div class="kode-pay">{{ $t->kode_pembayaran }}</div>
                        @if($t->catatan)
                        <div class="sub-text">{{ Str::limit($t->catatan, 30) }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:12px;">{{ \Carbon\Carbon::parse($t->tanggal_bayar)->format('d M Y') }}</div>
                        <div class="sub-text">{{ \Carbon\Carbon::parse($t->tanggal_bayar)->format('H:i') }}</div>
                    </td>
                    <td>
                        <div class="plat-nomor">{{ $t->servis->kendaraan->plat_nomor ?? '-' }}</div>
                        <div class="sub-text">{{ $t->servis->kendaraan->nama_pemilik ?? '-' }}</div>
                    </td>
                    <td>
                        <div style="font-size:12px;">{{ $t->servis->mekanik->nama_mekanik ?? '-' }}</div>
                    </td>
                    <td>Rp {{ number_format($t->biaya_jasa, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->biaya_sparepart, 0, ',', '.') }}</td>
                    <td style="font-weight:500; color:#0f172a;">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $metodeCls = match($t->metode_bayar) {
                                'Tunai'    => 'badge-tunai',
                                'Transfer' => 'badge-transfer',
                                'Debit'    => 'badge-debit',
                                default    => 'badge-tunai',
                            };
                        @endphp
                        <span class="badge-status {{ $metodeCls }}">{{ $t->metode_bayar }}</span>
                    </td>
                    <td>
                        @php
                            $statusCls = match($t->status) {
                                'Lunas'      => 'badge-lunas',
                                'Belum Lunas'=> 'badge-belum',
                                'Cicilan'    => 'badge-cicilan',
                                default      => 'badge-lunas',
                            };
                        @endphp
                        <span class="badge-status {{ $statusCls }}">{{ $t->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <i class="ti ti-file-off"></i>
                            Tidak ada data transaksi untuk periode ini
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($transaksi->count() > 0)
            <tfoot>
                <tr style="background:#f8fafc;">
                    <td colspan="5" style="font-size:12px; font-weight:500; color:#374151; padding:10px 14px;">
                        Total (halaman ini)
                    </td>
                    <td style="font-weight:500; font-size:12.5px; padding:10px 14px;">
                        Rp {{ number_format($transaksi->sum('biaya_jasa'), 0, ',', '.') }}
                    </td>
                    <td style="font-weight:500; font-size:12.5px; padding:10px 14px;">
                        Rp {{ number_format($transaksi->sum('biaya_sparepart'), 0, ',', '.') }}
                    </td>
                    <td style="font-weight:600; font-size:13px; color:#16a34a; padding:10px 14px;">
                        Rp {{ number_format($transaksi->sum('total_bayar'), 0, ',', '.') }}
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
        </div>

        {{-- Pagination --}}
        @if($transaksi->hasPages())
        <div class="pagination-wrap">
            <span class="pagination-info">
                Menampilkan {{ $transaksi->firstItem() }}–{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} data
            </span>
            {{ $transaksi->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</div>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ── Data dari controller ──
const grafikLabels  = @json($grafikLabels);
const grafikJasa    = @json($grafikJasa);
const grafikPart    = @json($grafikSparepart);
const metodeLabels  = @json($metodeLabels);
const metodeValues  = @json($metodeValues);

// ── Grafik Pendapatan (Stacked Bar) ──
new Chart(document.getElementById('grafikPendapatan'), {
    type: 'bar',
    data: {
        labels: grafikLabels,
        datasets: [
            {
                label: 'Biaya Jasa',
                data: grafikJasa,
                backgroundColor: '#f59e0b',
                borderRadius: 4,
                borderSkipped: false,
            },
            {
                label: 'Biaya Sparepart',
                data: grafikPart,
                backgroundColor: '#3b82f6',
                borderRadius: 4,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: { font: { size: 11 }, boxWidth: 12, padding: 12 }
            },
            tooltip: {
                callbacks: {
                    label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: {
                stacked: true,
                ticks: { font: { size: 10 } },
                grid: { display: false }
            },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    font: { size: 10 },
                    callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1)+'jt' : v >= 1000 ? (v/1000).toFixed(0)+'rb' : v)
                },
                grid: { color: 'rgba(0,0,0,.04)' }
            }
        }
    }
});

// ── Donut Metode Bayar ──
const metodeColors = ['#22c55e', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444'];
new Chart(document.getElementById('grafikMetode'), {
    type: 'doughnut',
    data: {
        labels: metodeLabels,
        datasets: [{
            data: metodeValues,
            backgroundColor: metodeColors.slice(0, metodeLabels.length),
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' transaksi'
                }
            }
        }
    }
});

// Custom legend donut
const legendEl = document.getElementById('legendMetode');
if (legendEl && metodeLabels.length) {
    legendEl.innerHTML = metodeLabels.map((label, i) => `
        <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
            <span style="width:10px;height:10px;border-radius:3px;background:${metodeColors[i]};flex-shrink:0;display:inline-block;"></span>
            <span style="font-size:11.5px;color:#374151;flex:1;">${label}</span>
            <span style="font-size:11px;color:#64748b;font-weight:500;">${metodeValues[i]}</span>
        </div>
    `).join('');
}

// ── Toggle custom date ──
function toggleCustomDate(val) {
    document.getElementById('customDateWrap').style.display = val === 'custom' ? 'flex' : 'none';
}
</script>
@endsection
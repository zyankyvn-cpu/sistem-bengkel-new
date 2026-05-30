@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('extra-css')
<style>
    /* ── Stats Cards ── */
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
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.09);
    }
    .stat-card.blue  { border-left-color: #3b82f6; }
    .stat-card.green { border-left-color: #22c55e; }
    .stat-card.amber { border-left-color: #f59e0b; }
    .stat-card.red   { border-left-color: #ef4444; }

    .stat-icon {
        width: 46px; height: 46px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }
    .stat-icon.blue  { background: #eff6ff; color: #2563eb; }
    .stat-icon.green { background: #f0fdf4; color: #16a34a; }
    .stat-icon.amber { background: #fffbeb; color: #d97706; }
    .stat-icon.red   { background: #fef2f2; color: #dc2626; }

    .stat-label { font-size: 11px; color: #64748b; margin-bottom: 3px; }
    .stat-value { font-size: 24px; font-weight: 500; color: #0f172a; line-height: 1; }
    .stat-value.sm { font-size: 15px; }

    .trend {
        font-size: 10px;
        display: flex; align-items: center; gap: 2px;
        margin-top: 4px;
    }
    .trend.up      { color: #16a34a; }
    .trend.down    { color: #dc2626; }
    .trend.neutral { color: #94a3b8; }

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

    /* ── Progress ── */
    .status-row { margin-bottom: 14px; }
    .status-row:last-child { margin-bottom: 0; }
    .status-meta {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 6px;
    }
    .status-name { font-size: 12.5px; color: #374151; }
    .progress-wrap {
        height: 6px; background: #f1f5f9;
        border-radius: 99px; overflow: hidden;
    }
    .progress-fill { height: 100%; border-radius: 99px; transition: width .6s ease; }

    /* ── Badge ── */
    .badge-status {
        font-size: 10px; font-weight: 500;
        padding: 3px 9px; border-radius: 20px;
        display: inline-block;
        transition: filter .15s ease;
    }
    .badge-status:hover  { filter: brightness(.93); }
    .badge-antrian { background: #fef3c7; color: #92400e; }
    .badge-proses  { background: #e0f2fe; color: #0369a1; }
    .badge-selesai { background: #dcfce7; color: #166534; }
    .badge-danger  { background: #fee2e2; color: #991b1b; }

    /* ── Tabel Servis ── */
    .servis-table { width: 100%; border-collapse: collapse; }
    .servis-table th {
        font-size: 11px; color: #64748b; font-weight: 500;
        padding: 8px 14px; text-align: left;
        border-bottom: 0.5px solid #e2e8f0;
        background: #f8fafc;
    }
    .servis-table td {
        font-size: 12.5px; color: #374151;
        padding: 9px 14px;
        border-bottom: 0.5px solid #f1f5f9;
    }
    .servis-table tbody tr:last-child td { border-bottom: none; }
    .servis-table tbody tr {
        transition: background .15s ease, box-shadow .15s ease;
    }
    .servis-table tbody tr:hover {
        background: #f0f9ff !important;
        box-shadow: inset 3px 0 0 #3b82f6;
    }
    .servis-table tbody tr.row-antrian { background: #fffbeb; }
    .servis-table tbody tr.row-antrian:hover {
        background: #fef3c7 !important;
        box-shadow: inset 3px 0 0 #f59e0b;
    }

    .plat-nomor   { font-weight: 500; color: #0f172a; }
    .nama-pemilik { font-size: 10px; color: #94a3b8; }

    /* ── Stok ── */
    .stok-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 16px;
        border-bottom: 0.5px solid #f1f5f9;
        transition: background .15s ease, box-shadow .15s ease;
        cursor: default;
    }
    .stok-item:last-child { border-bottom: none; }
    .stok-item:hover {
        background: #f8fafc;
        box-shadow: inset 3px 0 0 #f59e0b;
    }
    .stok-name { font-size: 12.5px; font-weight: 500; color: #0f172a; }
    .stok-cat  { font-size: 10px; color: #94a3b8; }

    /* ── Activity Feed ── */
    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #22c55e;
        display: inline-block;
        margin-right: 6px;
        animation: pulse-dot 1.6s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .4; transform: scale(.7); }
    }
    .live-badge {
        font-size: 10px; font-weight: 600;
        color: #16a34a;
        display: flex; align-items: center; gap: 4px;
    }
    .feed-list { padding: 0; margin: 0; list-style: none; }
    .feed-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 16px;
        border-bottom: 0.5px solid #f1f5f9;
        transition: background .15s ease, box-shadow .15s ease;
    }
    .feed-item:last-child { border-bottom: none; }
    .feed-item:hover {
        background: #f0f9ff !important;
        box-shadow: inset 3px 0 0 #3b82f6;
    }
    .feed-item.feed-new { animation: feed-flash .6s ease-out; }
    @keyframes feed-flash {
        from { background: #fef9c3; }
        to   { background: transparent; }
    }
    .feed-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 15px;
    }
    .feed-icon.amber { background: #fef3c7; color: #d97706; }
    .feed-icon.blue  { background: #eff6ff; color: #2563eb; }
    .feed-icon.green { background: #f0fdf4; color: #16a34a; }
    .feed-icon.gray  { background: #f1f5f9; color: #64748b; }
    .feed-text { flex: 1; min-width: 0; }
    .feed-main { font-size: 12.5px; color: #374151; line-height: 1.4; }
    .feed-main strong { color: #0f172a; font-weight: 500; }
    .feed-time { font-size: 10.5px; color: #94a3b8; margin-top: 2px; }
    .feed-empty {
        padding: 28px 16px;
        text-align: center;
        color: #94a3b8; font-size: 12.5px;
    }
    .feed-refresh-info {
        padding: 8px 16px;
        border-top: 0.5px solid #f1f5f9;
        font-size: 10.5px; color: #94a3b8;
        display: flex; align-items: center; justify-content: space-between;
    }
    #feedCountdown { font-weight: 500; color: #64748b; }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="ti ti-car"></i></div>
                <div>
                    <div class="stat-label">Total Kendaraan</div>
                    <div class="stat-value counter" data-target="{{ $TotalKendaraan }}">0</div>
                    <div class="trend neutral"><i class="bi bi-dash"></i> Data kendaraan terdaftar</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="ti ti-user-check"></i></div>
                <div>
                    <div class="stat-label">Mekanik Aktif</div>
                    <div class="stat-value counter" data-target="{{ $TotalMekanik }}">0</div>
                    <div class="trend up"><i class="bi bi-arrow-up-short"></i> Siap bertugas</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card amber">
                <div class="stat-icon amber"><i class="ti ti-tool"></i></div>
                <div>
                    <div class="stat-label">Total Servis</div>
                    <div class="stat-value counter" data-target="{{ $TotalServis }}">0</div>
                    <div class="trend up"><i class="bi bi-arrow-up-short"></i> Bulan ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card red">
                <div class="stat-icon red"><i class="ti ti-cash"></i></div>
                <div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value sm" id="pendapatanVal">Rp 0</div>
                    <div class="trend {{ $TotalPendapatan > 0 ? 'up' : 'neutral' }}">
                        <i class="bi bi-{{ $TotalPendapatan > 0 ? 'arrow-up-short' : 'dash' }}"></i>
                        {{ $TotalPendapatan > 0 ? 'Ada pemasukan' : 'Belum ada pembayaran' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Servis & Grafik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="dash-card h-100">
                <div class="dash-card-head">
                    <i class="ti ti-chart-pie"></i>
                    <span>Status Servis</span>
                </div>
                <div class="dash-card-body">
                    <div class="status-row">
                        <div class="status-meta">
                            <span class="status-name">Antrian</span>
                            <span class="badge-status badge-antrian">{{ $ServisAntrian }}</span>
                        </div>
                        <div class="progress-wrap">
                            <div class="progress-fill" style="width:{{ $TotalServis ? ($ServisAntrian/$TotalServis)*100 : 0 }}%; background:#f59e0b;"></div>
                        </div>
                    </div>
                    <div class="status-row">
                        <div class="status-meta">
                            <span class="status-name">Proses</span>
                            <span class="badge-status badge-proses">{{ $ServisProses }}</span>
                        </div>
                        <div class="progress-wrap">
                            <div class="progress-fill" style="width:{{ $TotalServis ? ($ServisProses/$TotalServis)*100 : 0 }}%; background:#38bdf8;"></div>
                        </div>
                    </div>
                    <div class="status-row">
                        <div class="status-meta">
                            <span class="status-name">Selesai</span>
                            <span class="badge-status badge-selesai">{{ $ServisSelesai }}</span>
                        </div>
                        <div class="progress-wrap">
                            <div class="progress-fill" style="width:{{ $TotalServis ? ($ServisSelesai/$TotalServis)*100 : 0 }}%; background:#22c55e;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="dash-card h-100">
                <div class="dash-card-head">
                    <i class="ti ti-chart-bar"></i>
                    <span>Servis per Bulan ({{ date('Y') }})</span>
                </div>
                <div class="dash-card-body">
                    <div style="position:relative; height:150px;">
                        <canvas id="GrafikServis" role="img" aria-label="Grafik bar jumlah servis per bulan tahun {{ date('Y') }}">Data servis per bulan.</canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stok Menipis & Servis Terbaru --}}
    <div class="row g-3">
        <div class="col-md-5">
            <div class="dash-card">
                <div class="dash-card-head">
                    <i class="ti ti-alert-triangle" style="color:#f59e0b;"></i>
                    <span>Stok Menipis</span>
                </div>
                @forelse($StokMenipis as $sp)
                <div class="stok-item">
                    <div>
                        <div class="stok-name">{{ $sp->nama_sparepart }}</div>
                        <div class="stok-cat">{{ $sp->kategori }}</div>
                    </div>
                    <span class="badge-status {{ $sp->stok <= 0 ? 'badge-danger' : 'badge-antrian' }}">
                        Stok: {{ $sp->stok }}
                    </span>
                </div>
                @empty
                <div class="p-4 text-center" style="color:#94a3b8; font-size:13px;">
                    <i class="ti ti-circle-check" style="font-size:28px; color:#22c55e; display:block; margin-bottom:6px;"></i>
                    Semua stok aman
                </div>
                @endforelse
            </div>
        </div>
        <div class="col-md-7">
            <div class="dash-card">
                <div class="dash-card-head">
                    <i class="ti ti-tool"></i>
                    <span>Servis Terbaru</span>
                </div>
                <table class="servis-table">
                    <thead>
                        <tr>
                            <th>Kendaraan</th>
                            <th>Mekanik</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ServisTerbaru as $s)
                        <tr class="{{ $s->status === 'Antrian' ? 'row-antrian' : '' }}">
                            <td>
                                <div class="plat-nomor">{{ $s->kendaraan->plat_nomor }}</div>
                                <div class="nama-pemilik">{{ $s->kendaraan->nama_pemilik }}</div>
                            </td>
                            <td>{{ $s->mekanik->nama_mekanik }}</td>
                            <td>
                                <span style="display:block; max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    {{ $s->keluhan }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $cls = match($s->status) {
                                        'Antrian' => 'badge-antrian',
                                        'Proses'  => 'badge-proses',
                                        'Selesai' => 'badge-selesai',
                                        default   => 'badge-danger'
                                    };
                                @endphp
                                <span class="badge-status {{ $cls }}">{{ $s->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Activity Feed --}}
<div class="row g-3 mt-0">
    <div class="col-12">
        <div class="dash-card">
            <div class="dash-card-head justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-activity"></i>
                    <span>Aktivitas Terbaru</span>
                </div>
                <div class="live-badge">
                    <span class="activity-dot"></span> Live
                </div>
            </div>
            <ul class="feed-list" id="activityFeed">
                <li class="feed-empty">
                    <i class="ti ti-loader" style="font-size:22px; display:block; margin-bottom:6px;"></i>
                    Memuat aktivitas...
                </li>
            </ul>
            <div class="feed-refresh-info">
                <span>Refresh otomatis setiap 15 detik</span>
                <span>Berikutnya: <span id="feedCountdown">15</span>s</span>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ── Chart Servis per Bulan ──
const NamaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
const DataServis = @json($ServisPerBulan);
const LabelServis = DataServis.map(d => NamaBulan[d.bulan - 1]);
const ValueServis = DataServis.map(d => d.total);

new Chart(document.getElementById('GrafikServis'), {
    type: 'bar',
    data: {
        labels: LabelServis,
        datasets: [{
            label: 'Jumlah Servis',
            data: ValueServis,
            backgroundColor: '#3b82f6',
            borderRadius: 5,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, font: { size: 10 } },
                grid: { color: 'rgba(0,0,0,.04)' }
            },
            x: {
                ticks: { font: { size: 10 } },
                grid: { display: false }
            }
        }
    }
});

// ── Animasi Counter ──
function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const duration = 900;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        el.textContent = Math.floor(current);
    }, 16);
}

document.querySelectorAll('.counter').forEach(el => animateCounter(el));

// ── Animasi Pendapatan ──
(function() {
    const target = {{ $TotalPendapatan }};
    const el = document.getElementById('pendapatanVal');
    if (!el) return;
    const duration = 900;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current += step;
        if (current >= target) { current = target; clearInterval(timer); }
        el.textContent = 'Rp ' + Math.floor(current).toLocaleString('id-ID');
    }, 16);
})();

    // ── Activity Feed ──
(function () {
    const feedEl    = document.getElementById('activityFeed');
    const countdown = document.getElementById('feedCountdown');
    const endpoint  = '{{ route("dashboard.activity-feed") }}';
    let timer, seconds = 15;
    let previousIds = [];

    function renderFeed(items) {
        if (!items.length) {
            feedEl.innerHTML = `
                <li class="feed-empty">
                    <i class="ti ti-mood-empty" style="font-size:22px;display:block;margin-bottom:6px;"></i>
                    Belum ada aktivitas
                </li>`;
            return;
        }

        const currentIds = items.map((_, i) => i + '_' + items[i].time);
        feedEl.innerHTML = items.map((item, i) => {
            const isNew = previousIds.length && previousIds[i] !== currentIds[i];
            return `
            <li class="feed-item ${isNew ? 'feed-new' : ''}">
                <div class="feed-icon ${item.color}">
                    <i class="ti ${item.icon}"></i>
                </div>
                <div class="feed-text">
                    <div class="feed-main">
                        <strong>${item.plat}</strong> (${item.pemilik})
                        ${item.label} oleh <strong>${item.mekanik}</strong>
                    </div>
                    <div class="feed-time"><i class="ti ti-clock" style="font-size:10px;"></i> ${item.time}</div>
                </div>
            </li>`;
        }).join('');

        previousIds = currentIds;
    }

    function fetchFeed() {
        fetch(endpoint, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => renderFeed(data))
        .catch(() => {
            feedEl.innerHTML = `<li class="feed-empty" style="color:#ef4444;">
                <i class="ti ti-wifi-off" style="font-size:22px;display:block;margin-bottom:6px;"></i>
                Gagal memuat aktivitas
            </li>`;
        });
    }

    function startCountdown() {
        clearInterval(timer);
        seconds = 15;
        countdown.textContent = seconds;
        timer = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                fetchFeed();
                seconds = 15;
            }
        }, 1000);
    }

    // Load pertama kali langsung
    fetchFeed();
    startCountdown();
})();
</script>
@endsection
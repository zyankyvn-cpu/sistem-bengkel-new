<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Bengkel') — Sistem Informasi Bengkel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { background-color: #f1f5f9; font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        .sidebar {
            width: 230px; min-height: 100vh;
            background: #0f172a;
            position: fixed; top: 0; left: 0;
            z-index: 100; display: flex; flex-direction: column;
            transition: transform .25s ease;
        }
        .sidebar-brand { padding: 20px 16px 16px; border-bottom: 0.5px solid rgba(255,255,255,.07); }
        .sidebar-brand .brand-icon {
            width: 36px; height: 36px; background: #f59e0b; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px; font-size: 18px; color: #fff;
        }
        .sidebar-brand h6 { color: #fff; font-weight: 500; margin: 0; font-size: 12px; line-height: 1.5; }
        .sidebar-brand small { color: #475569; font-size: 10px; }
        .nav-label {
            color: #334155; font-size: 9px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1.2px; padding: 14px 16px 5px;
        }
        .sidebar .nav-link {
            color: #94a3b8; padding: 8px 16px; font-size: 12.5px;
            display: flex; align-items: center; gap: 10px;
            border-radius: 0; border-left: 2px solid transparent; transition: all .18s ease;
        }
        .sidebar .nav-link i { font-size: 15px; }
        .sidebar .nav-link:hover {
            color: #f1f5f9; background: rgba(255,255,255,.07);
            padding-left: 20px; border-left-color: rgba(245,158,11,.4);
        }
        .sidebar .nav-link.active { color: #f59e0b; background: rgba(245,158,11,.08); border-left: 2px solid #f59e0b; }

        /* ── Overlay mobile ── */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 99;
        }
        .sidebar-overlay.show { display: block; }

        /* ── Main ── */
        .main-content { margin-left: 230px; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Topbar ── */
        .topbar {
            background: #fff; border-bottom: 0.5px solid #e2e8f0;
            padding: 11px 24px; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 98;
        }
        .topbar-left { display: flex; align-items: center; gap: 10px; }
        .topbar-title { margin: 0; font-size: 14px; font-weight: 500; color: #0f172a; }
        .topbar-sub   { color: #94a3b8; font-size: 11px; }
        .topbar-greeting { font-size: 12px; color: #64748b; font-style: italic; }

        /* Hamburger - hidden desktop */
        .hamburger-btn {
            display: none; width: 34px; height: 34px; border-radius: 8px;
            border: 0.5px solid #e2e8f0; background: transparent;
            align-items: center; justify-content: center;
            cursor: pointer; color: #64748b; font-size: 18px;
            transition: background .15s; flex-shrink: 0;
        }
        .hamburger-btn:hover { background: #f8fafc; color: #0f172a; }

        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%; background: #f59e0b;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 500; color: #fff; cursor: pointer; transition: opacity .15s;
        }
        .user-avatar:hover { opacity: .85; }
        .user-name { font-size: 12.5px; color: #475569; cursor: pointer; }

        /* Dropdown profil */
        .profile-dropdown .dropdown-toggle::after { display: none; }
        .profile-dropdown .dropdown-menu {
            min-width: 210px; border: 0.5px solid #e2e8f0; border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,.09); padding: 6px 0; margin-top: 6px !important;
        }
        .profile-dropdown .dropdown-header { padding: 10px 14px 8px; border-bottom: 0.5px solid #f1f5f9; margin-bottom: 4px; }
        .profile-dropdown .dropdown-header .name { font-size: 13px; font-weight: 500; color: #0f172a; }
        .profile-dropdown .dropdown-header .role { font-size: 10.5px; color: #94a3b8; margin-top: 1px; }
        .profile-dropdown .dropdown-item {
            font-size: 12.5px; color: #374151; padding: 7px 14px;
            display: flex; align-items: center; gap: 8px; transition: background .12s;
        }
        .profile-dropdown .dropdown-item:hover { background: #f8fafc; color: #0f172a; }
        .profile-dropdown .dropdown-item i { font-size: 15px; color: #94a3b8; }
        .profile-dropdown .dropdown-divider { border-color: #f1f5f9; margin: 4px 0; }
        .profile-dropdown .item-logout { color: #ef4444; }
        .profile-dropdown .item-logout i { color: #ef4444; }
        .profile-dropdown .item-logout:hover { background: #fef2f2; }

        /* ── Notifikasi Bell ── */
        .notif-btn {
            position: relative; width: 34px; height: 34px; border-radius: 8px;
            background: transparent; border: 0.5px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: #64748b; font-size: 17px; transition: background .15s, color .15s;
        }
        .notif-btn:hover { background: #f8fafc; color: #0f172a; }
        .notif-badge {
            position: absolute; top: -4px; right: -4px; width: 16px; height: 16px;
            background: #ef4444; border-radius: 50%; font-size: 9px; font-weight: 600;
            color: #fff; display: flex; align-items: center; justify-content: center; border: 2px solid #fff;
        }
        .notif-dropdown .dropdown-menu {
            min-width: 270px; border: 0.5px solid #e2e8f0; border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,.09); padding: 0; margin-top: 6px !important; overflow: hidden;
        }
        .notif-head { padding: 10px 14px; border-bottom: 0.5px solid #f1f5f9; font-size: 12px; font-weight: 500; color: #0f172a; }
        .notif-item { display: flex; align-items: center; gap: 10px; padding: 9px 14px; border-bottom: 0.5px solid #f8fafc; font-size: 12px; color: #374151; }
        .notif-item:last-child { border-bottom: none; }
        .notif-item-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 14px; }
        .notif-item-icon.danger  { background: #fee2e2; color: #dc2626; }
        .notif-item-icon.warning { background: #fef3c7; color: #d97706; }
        .notif-nama { font-weight: 500; font-size: 12px; color: #0f172a; }
        .notif-stok { font-size: 10.5px; color: #94a3b8; }
        .notif-empty { padding: 20px 14px; text-align: center; color: #94a3b8; font-size: 12px; }
        .notif-empty i { font-size: 24px; color: #22c55e; display: block; margin-bottom: 4px; }
        .notif-item.is-read { opacity: .45; }
        .notif-item.is-read .notif-nama { text-decoration: line-through; color: #94a3b8; }
        .notif-actions { padding: 8px 14px; border-top: 0.5px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 8px; }
        .notif-action-btn {
            font-size: 10.5px; color: #64748b; background: none; border: 0.5px solid #e2e8f0;
            border-radius: 6px; padding: 4px 10px; cursor: pointer; transition: background .12s, color .12s;
        }
        .notif-action-btn:hover { background: #f1f5f9; color: #0f172a; }
        .notif-action-btn.danger { color: #ef4444; border-color: #fecaca; }
        .notif-action-btn.danger:hover { background: #fef2f2; }
        .notif-mark-btn {
            margin-left: auto; flex-shrink: 0; width: 22px; height: 22px; border-radius: 6px;
            border: 0.5px solid #e2e8f0; background: none; display: flex; align-items: center;
            justify-content: center; cursor: pointer; color: #94a3b8; font-size: 13px;
            transition: background .12s, color .12s, border-color .12s;
        }
        .notif-mark-btn:hover { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
        .notif-item.is-read .notif-mark-btn { color: #16a34a; border-color: #bbf7d0; background: #f0fdf4; }

        /* ── FAB ── */
        .fab-wrap { position: fixed; bottom: 24px; right: 24px; z-index: 200; display: flex; flex-direction: column-reverse; align-items: flex-end; gap: 10px; }
        .fab-main {
            width: 46px; height: 46px; border-radius: 12px; background: #f59e0b; border: none;
            color: #fff; font-size: 20px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; box-shadow: 0 4px 14px rgba(245,158,11,.35); transition: background .15s, transform .15s;
        }
        .fab-main:hover { background: #d97706; transform: scale(1.05); }
        .fab-main .ti { transition: transform .25s; }
        .fab-main.open .ti { transform: rotate(45deg); }
        .fab-actions {
            display: flex; flex-direction: column; align-items: flex-end; gap: 8px;
            opacity: 0; pointer-events: none; transform: translateY(8px); transition: opacity .2s, transform .2s;
        }
        .fab-actions.show { opacity: 1; pointer-events: auto; transform: translateY(0); }
        .fab-action-item { display: flex; align-items: center; gap: 10px; cursor: pointer; text-decoration: none; }
        .fab-action-label { background: #0f172a; color: #e2e8f0; font-size: 11.5px; padding: 5px 11px; border-radius: 7px; white-space: nowrap; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
        .fab-action-btn {
            width: 38px; height: 38px; border-radius: 10px; border: none;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: #fff; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,.12); transition: opacity .15s;
        }
        .fab-action-btn:hover { opacity: .88; }
        .fab-action-btn.blue   { background: #3b82f6; }
        .fab-action-btn.green  { background: #22c55e; }
        .fab-action-btn.amber  { background: #f59e0b; }
        .fab-action-btn.red    { background: #ef4444; }
        .fab-action-btn.purple { background: #8b5cf6; }

        /* ── Page body ── */
        .page-body { padding: 22px 24px; flex: 1; }

        /* ══════════════════════════════════════
           RESPONSIVE MOBILE
        ══════════════════════════════════════ */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); z-index: 101; width: 240px; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar { padding: 10px 14px; }
            .topbar-title { font-size: 13px; }
            .topbar-greeting { display: none; }
            .hamburger-btn { display: flex; }
            .user-name { display: none; }
            .page-body { padding: 14px 12px; }
            .fab-wrap { bottom: 16px; right: 16px; }
        }

        @yield('extra-css')
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

{{-- Overlay sidebar mobile --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ── Quick Actions FAB ── --}}
<div class="fab-wrap" id="fabWrap">
    <button class="fab-main" id="fabMain" onclick="toggleFab()" title="Quick Actions">
        <i class="ti ti-plus"></i>
    </button>
    <div class="fab-actions" id="fabActions">
        @hasanyrole('Admin|Kasir')
        <a href="{{ route('servis.create') }}" class="fab-action-item">
            <span class="fab-action-label">Servis Baru</span>
            <span class="fab-action-btn amber"><i class="ti ti-tool"></i></span>
        </a>
        @endhasanyrole
        @hasanyrole('Admin|Kasir')
        <a href="{{ route('pembayaran.create') }}" class="fab-action-item">
            <span class="fab-action-label">Input Pembayaran</span>
            <span class="fab-action-btn green"><i class="ti ti-credit-card"></i></span>
        </a>
        @endhasanyrole
        @role('Admin')
        <a href="{{ route('kendaraan.create') }}" class="fab-action-item">
            <span class="fab-action-label">Tambah Kendaraan</span>
            <span class="fab-action-btn blue"><i class="ti ti-car"></i></span>
        </a>
        @endrole
        @role('Admin')
        <a href="{{ route('sparepart.create') }}" class="fab-action-item">
            <span class="fab-action-label">Tambah Sparepart</span>
            <span class="fab-action-btn red"><i class="ti ti-settings"></i></span>
        </a>
        @endrole
        @hasanyrole('Admin|Owner')
        <a href="{{ route('laporan.index') }}" class="fab-action-item">
            <span class="fab-action-label">Lihat Laporan</span>
            <span class="fab-action-btn purple"><i class="ti ti-chart-bar"></i></span>
        </a>
        @endhasanyrole
    </div>
</div>

{{-- SIDEBAR --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="ti ti-tool"></i></div>
        <h6>Sistem Informasi<br>Bengkel Motor & Mobil</h6>
        <small>v1.0.0</small>
    </div>
    <div class="mt-1">
        <div class="nav-label">Dashboard</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
        @role('Admin')
        <div class="nav-label">Data Master</div>
        <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->is('kendaraan*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-car"></i> Data Kendaraan
        </a>
        <a href="{{ route('sparepart.index') }}" class="nav-link {{ request()->is('sparepart*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-settings"></i> Data Sparepart
        </a>
        <a href="{{ route('mekanik.index') }}" class="nav-link {{ request()->is('mekanik*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-user-check"></i> Data Mekanik
        </a>
        @endrole
        @hasanyrole('Admin|Kasir')
        <div class="nav-label">Transaksi</div>
        <a href="{{ route('servis.index') }}" class="nav-link {{ request()->is('servis*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-tool"></i> Servis
        </a>
        <a href="{{ route('pembayaran.index') }}" class="nav-link {{ request()->is('pembayaran*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-credit-card"></i> Pembayaran
        </a>
        @endhasanyrole
        @hasanyrole('Admin|Owner')
        <div class="nav-label">Laporan</div>
        <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" onclick="closeSidebar()">
            <i class="ti ti-chart-bar"></i> Laporan Penjualan
        </a>
        @endhasanyrole
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <button class="hamburger-btn" onclick="toggleSidebar()">
                <i class="ti ti-menu-2"></i>
            </button>
            <div>
                <h5 class="topbar-title">@yield('title', 'Dashboard')</h5>
                <div class="d-flex align-items-center gap-2">
                    <small class="topbar-sub">@yield('breadcrumb', 'Beranda')</small>
                    <small class="topbar-greeting" id="greeting"></small>
                </div>
            </div>
        </div>

        @php
            $notifStok = auth()->check() ? \App\Models\Sparepart::where('stok', '<=', 5)->get() : collect();
        @endphp
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown notif-dropdown">
                <button class="notif-btn" id="notifToggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti ti-bell"></i>
                    @if($notifStok->count() > 0)
                    <span class="notif-badge" id="notifBadge">{{ $notifStok->count() }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end" id="notifMenu">
                    <li>
                        <div class="notif-head d-flex align-items-center justify-content-between">
                            <span><i class="ti ti-bell me-1"></i> Stok Menipis</span>
                            <span id="notifUnreadCount" style="font-size:10px; color:#94a3b8;"></span>
                        </div>
                    </li>
                    @forelse($notifStok as $sp)
                    <li>
                        <div class="notif-item" id="notif-item-{{ $sp->id }}" data-id="{{ $sp->id }}" data-stok="{{ $sp->stok }}">
                            <div class="notif-item-icon {{ $sp->stok <= 0 ? 'danger' : 'warning' }}">
                                <i class="ti ti-{{ $sp->stok <= 0 ? 'alert-circle' : 'alert-triangle' }}"></i>
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div class="notif-nama">{{ $sp->nama_sparepart }}</div>
                                <div class="notif-stok">{{ $sp->kategori }} &bull; Stok: {{ $sp->stok }}</div>
                            </div>
                            <button class="notif-mark-btn" onclick="toggleReadNotif({{ $sp->id }}, this)" title="Tandai dibaca">
                                <i class="ti ti-check"></i>
                            </button>
                        </div>
                    </li>
                    @empty
                    <li>
                        <div class="notif-empty">
                            <i class="ti ti-circle-check"></i>
                            Semua stok aman
                        </div>
                    </li>
                    @endforelse
                    @if($notifStok->count() > 0)
                    <li>
                        <div class="notif-actions">
                            <button class="notif-action-btn" onclick="markAllRead()">
                                <i class="ti ti-checks" style="font-size:11px;"></i> Tandai semua dibaca
                            </button>
                            <button class="notif-action-btn danger" onclick="resetReadNotif()">
                                <i class="ti ti-refresh" style="font-size:11px;"></i> Reset
                            </button>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="dropdown profile-dropdown">
                <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                    <div class="user-avatar" id="userInitials">?</div>
                    <span class="user-name">{{ auth()->user()->name ?? 'Guest' }}</span>
                    <i class="ti ti-chevron-down" style="font-size:13px; color:#94a3b8;"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="user-avatar" id="userInitials2" style="width:36px;height:36px;font-size:13px;">?</div>
                                <div>
                                    <div class="name">{{ auth()->user()->name ?? 'Guest' }}</div>
                                    <div class="role">{{ auth()->check() ? (auth()->user()->getRoleNames()->first() ?? 'User') : 'Guest' }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <span class="dropdown-item text-muted" style="cursor:default; font-size:11.5px;">
                            <i class="ti ti-mail"></i> {{ auth()->user()->email ?? '-' }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" id="logoutForm">@csrf</form>
                        <button type="button" onclick="konfirmasiLogout()" class="dropdown-item item-logout w-100 border-0 bg-transparent">
                            <i class="ti ti-logout"></i> Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-body">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function() {
        const hour = new Date().getHours();
        const greet = hour < 11 ? 'Selamat pagi' : hour < 15 ? 'Selamat siang' : hour < 18 ? 'Selamat sore' : 'Selamat malam';
        const el = document.getElementById('greeting');
        if (el) el.textContent = '— ' + greet + '!';
        const name = '{{ auth()->check() ? auth()->user()->name : "" }}';
        const initials = name.split(' ').map(w => w[0]).slice(0,2).join('').toUpperCase();
        ['userInitials','userInitials2'].forEach(id => {
            const av = document.getElementById(id);
            if (av && initials) av.textContent = initials;
        });
    })();

    function konfirmasiLogout() {
        Swal.fire({
            title: 'Yakin mau logout?',
            text: 'Kamu akan keluar dari sistem.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, logout',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('logoutForm').submit();
        });
    }

    // FAB
    function toggleFab() {
        const btn = document.getElementById('fabMain');
        const actions = document.getElementById('fabActions');
        const isOpen = actions.classList.contains('show');
        actions.classList.toggle('show', !isOpen);
        btn.classList.toggle('open', !isOpen);
    }
    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('fabWrap');
        if (wrap && !wrap.contains(e.target)) {
            document.getElementById('fabActions').classList.remove('show');
            document.getElementById('fabMain').classList.remove('open');
        }
    });

    // Sidebar mobile
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
</script>

@yield('extra-js')

<script>
(function () {
    const serverItems = @json($notifStok->map(fn($s) => ['id' => $s->id, 'stok' => $s->stok]));
    const LS_KEY = 'notif_read_stok';

    function getReadIds() {
        try {
            const raw = JSON.parse(localStorage.getItem(LS_KEY) || '{}');
            const valid = {};
            serverItems.forEach(item => {
                if (raw[item.id] !== undefined && raw[item.id] === item.stok) valid[item.id] = item.stok;
            });
            return valid;
        } catch { return {}; }
    }
    function saveReadIds(obj) { localStorage.setItem(LS_KEY, JSON.stringify(obj)); }
    function applyReadState() {
        const readIds = getReadIds();
        let unread = 0;
        serverItems.forEach(item => {
            const el = document.getElementById('notif-item-' + item.id);
            if (!el) return;
            if (readIds[item.id] !== undefined) { el.classList.add('is-read'); }
            else { el.classList.remove('is-read'); unread++; }
        });
        const badge = document.getElementById('notifBadge');
        if (badge) { badge.textContent = unread; badge.style.display = unread > 0 ? 'flex' : 'none'; }
        const counter = document.getElementById('notifUnreadCount');
        if (counter && serverItems.length > 0) {
            counter.textContent = (serverItems.length - unread) + '/' + serverItems.length + ' dibaca';
        }
    }
    window.toggleReadNotif = function(id) {
        const readIds = getReadIds();
        const item = serverItems.find(i => i.id === id);
        if (!item) return;
        if (readIds[id] !== undefined) delete readIds[id]; else readIds[id] = item.stok;
        saveReadIds(readIds); applyReadState();
    };
    window.markAllRead = function() {
        const readIds = getReadIds();
        serverItems.forEach(item => { readIds[item.id] = item.stok; });
        saveReadIds(readIds); applyReadState();
    };
    window.resetReadNotif = function() { localStorage.removeItem(LS_KEY); applyReadState(); };
    applyReadState();
})();
</script>
</body>
</html>
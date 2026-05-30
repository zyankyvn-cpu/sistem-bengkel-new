<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pembayaran;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /* ──────────────────────────────────────────
     |  INDEX — halaman utama laporan
     ────────────────────────────────────────── */
    public function index(Request $request)
    {
        // 1. Tentukan rentang tanggal berdasarkan pilihan periode
        [$dari, $sampai, $periodeLabel] = $this->resolvePeriode($request);

        $metode       = $request->input('metode', '');
        $statusFilter = $request->input('status', '');

        // 2. Base query gabungan pembayaran + servis (selesai)
        $query = Pembayaran::with(['servis.kendaraan', 'servis.mekanik'])
            ->whereBetween('tanggal_bayar', [$dari->startOfDay(), $sampai->copy()->endOfDay()])
            ->orderByDesc('tanggal_bayar');

        if ($metode)       $query->where('metode_bayar', $metode);
        if ($statusFilter) $query->where('status', $statusFilter);

        // 3. Summary (sebelum paginate)
        $summaryQuery = clone $query;
        $summary = [
            'total_pendapatan' => $summaryQuery->sum('total_bayar'),
            'total_biaya_jasa'       => $summaryQuery->sum('total_biaya_jasa'),
            'total_biaya_sparepart'  => $summaryQuery->sum('total_biaya_sparepart'),
            'jumlah_transaksi' => $summaryQuery->count(),
        ];

        // 4. Paginate
        $transaksi = $query->paginate(15)->withQueryString();

        // 5. Data grafik (pendapatan per label periode)
        [$grafikLabels, $grafikJasa, $grafikSparepart] = $this->buildGrafikData($request, $dari, $sampai, $metode, $statusFilter);

        // 6. Donut metode bayar
        $metodeStat = Pembayaran::whereBetween('tanggal_bayar', [$dari->copy()->startOfDay(), $sampai->copy()->endOfDay()])
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->select('metode_bayar', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_bayar')
            ->get();

        $metodeLabels = $metodeStat->pluck('metode_bayar')->toArray();
        $metodeValues = $metodeStat->pluck('total')->toArray();

        return view('laporan.index', compact(
            'transaksi',
            'summary',
            'grafikLabels',
            'grafikJasa',
            'grafikSparepart',
            'metodeLabels',
            'metodeValues',
            'periodeLabel',
            'dari',
            'sampai',
            'metode',
            'statusFilter',
        ) + ['periode' => $request->input('periode', 'bulanan')]);
    }

    /* ──────────────────────────────────────────
     |  EXPORT PDF
     ────────────────────────────────────────── */
    public function exportPdf(Request $request)
    {
        [$dari, $sampai, $periodeLabel] = $this->resolvePeriode($request);

        $transaksi = Pembayaran::with(['servis.kendaraan', 'servis.mekanik'])
            ->whereBetween('tanggal_bayar', [$dari->startOfDay(), $sampai->copy()->endOfDay()])
            ->when($request->metode,  fn($q) => $q->where('metode_bayar', $request->metode))
            ->when($request->status,  fn($q) => $q->where('status', $request->status))
            ->orderByDesc('tanggal_bayar')
            ->get();

        $summary = [
            'total_pendapatan' => $transaksi->sum('total_bayar'),
            'total_biaya_jasa'       => $transaksi->sum('total_biaya_jasa'),
            'total_biaya_sparepart'  => $transaksi->sum('total_biaya_sparepart'),
            'jumlah_transaksi' => $transaksi->count(),
        ];

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksi', 'summary', 'periodeLabel', 'dari', 'sampai'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penjualan-' . $dari->format('Ymd') . '-' . $sampai->format('Ymd') . '.pdf');
    }

    /* ──────────────────────────────────────────
     |  EXPORT EXCEL
     ────────────────────────────────────────── */
    public function exportExcel(Request $request)
    {
        [$dari, $sampai] = $this->resolvePeriode($request);

        return Excel::download(
            new LaporanExport($dari, $sampai, $request->metode, $request->status),
            'laporan-penjualan-' . $dari->format('Ymd') . '-' . $sampai->format('Ymd') . '.xlsx'
        );
    }

    /* ──────────────────────────────────────────
     |  HELPER: Resolve Periode → [dari, sampai, label]
     ────────────────────────────────────────── */
    private function resolvePeriode(Request $request): array
    {
        $periode = $request->input('periode', 'bulanan');

        switch ($periode) {
            case 'harian':
                $dari    = Carbon::today();
                $sampai  = Carbon::today();
                $label   = 'Hari ini, ' . $dari->translatedFormat('d F Y');
                break;

            case 'mingguan':
                $dari    = Carbon::now()->startOfWeek();
                $sampai  = Carbon::now()->endOfWeek();
                $label   = 'Minggu ini (' . $dari->format('d M') . ' – ' . $sampai->format('d M Y') . ')';
                break;

            case 'tahunan':
                $dari    = Carbon::now()->startOfYear();
                $sampai  = Carbon::now()->endOfYear();
                $label   = 'Tahun ' . $dari->format('Y');
                break;

            case 'custom':
                $dari   = Carbon::parse($request->input('dari',   now()->startOfMonth()));
                $sampai = Carbon::parse($request->input('sampai', now()));
                $label  = $dari->format('d M Y') . ' – ' . $sampai->format('d M Y');
                break;

            default: // bulanan
                $dari    = Carbon::now()->startOfMonth();
                $sampai  = Carbon::now()->endOfMonth();
                $label   = 'Bulan ' . $dari->translatedFormat('F Y');
                break;
        }

        return [$dari, $sampai, $label];
    }

    /* ──────────────────────────────────────────
     |  HELPER: Build data grafik
     ────────────────────────────────────────── */
    private function buildGrafikData(Request $request, Carbon $dari, Carbon $sampai, $metode, $statusFilter): array
    {
        $periode = $request->input('periode', 'bulanan');

        // Tentukan grouping SQL
        if ($periode === 'tahunan') {
            $groupFormat  = '%m';        // per bulan dalam setahun
            $labelFormat  = fn($v) => Carbon::createFromFormat('m', $v)->translatedFormat('M');
        } elseif ($periode === 'mingguan') {
            $groupFormat  = '%d/%m';     // per hari dalam seminggu
            $labelFormat  = fn($v) => $v;
        } elseif ($periode === 'harian') {
            $groupFormat  = '%H:00';
            $labelFormat  = fn($v) => $v;
        } else {
            $groupFormat  = '%d';        // per tanggal dalam sebulan
            $labelFormat  = fn($v) => $v;
        }

        $rows = Pembayaran::whereBetween('tanggal_bayar', [$dari->startOfDay(), $sampai->copy()->endOfDay()])
            ->when($metode,       fn($q) => $q->where('metode_bayar', $metode))
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->select(
                DB::raw("DATE_FORMAT(tanggal_bayar, '$groupFormat') as label"),
                DB::raw('SUM(total_biaya_jasa) as total_jasa'),
                DB::raw('SUM(total_biaya_sparepart) as total_sparepart')
            )
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $labels     = $rows->map(fn($r) => $labelFormat($r->label))->toArray();
        $jasa       = $rows->pluck('total_jasa')->map(fn($v) => (int)$v)->toArray();
        $sparepart  = $rows->pluck('total_sparepart')->map(fn($v) => (int)$v)->toArray();

        return [$labels, $jasa, $sparepart];
    }
}
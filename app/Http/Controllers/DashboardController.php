<?php
namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Sparepart;
use App\Models\Mekanik;
use App\Models\Servis;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $TotalKendaraan  = Kendaraan::count();
        $TotalSparepart  = Sparepart::count();
        $TotalMekanik    = Mekanik::where('status', 'Aktif')->count();
        $TotalServis     = Servis::count();
        $ServisAntrian   = Servis::where('status', 'Antrian')->count();
        $ServisProses    = Servis::where('status', 'Proses')->count();
        $ServisSelesai   = Servis::where('status', 'Selesai')->count();
        $StokMenipis     = Sparepart::whereColumn('stok', '<=', 'stok_minimum')->get();
        $TotalPendapatan = Pembayaran::where('status', 'Lunas')->sum('total_bayar');

        // Servis per bulan (6 bulan terakhir)
        $ServisPerBulan = Servis::select(
                DB::raw('MONTH(tanggal_servis) as bulan'),
                DB::raw('YEAR(tanggal_servis) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal_servis', date('Y'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        // Pendapatan per bulan
        $PendapatanPerBulan = Pembayaran::select(
                DB::raw('MONTH(tanggal_bayar) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereYear('tanggal_bayar', date('Y'))
            ->where('status', 'Lunas')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $ServisTerbaru = Servis::with(['kendaraan', 'mekanik'])
            ->latest()->take(5)->get();

        return view('dashboard', compact(
            'TotalKendaraan', 'TotalSparepart', 'TotalMekanik',
            'TotalServis', 'ServisAntrian', 'ServisProses', 'ServisSelesai',
            'StokMenipis', 'TotalPendapatan', 'ServisPerBulan',
            'PendapatanPerBulan', 'ServisTerbaru'
        ));
    }
    public function activityFeed()
{
    $activities = \App\Models\Servis::with(['kendaraan', 'mekanik'])
        ->latest('updated_at')
        ->limit(8)
        ->get()
        ->map(function ($s) {
            $label = match($s->status) {
                'Antrian' => 'masuk antrian',
                'Proses'  => 'mulai dikerjakan',
                'Selesai' => 'selesai dikerjakan',
                default   => 'diperbarui',
            };
            $icon = match($s->status) {
                'Antrian' => 'ti-clock',
                'Proses'  => 'ti-tool',
                'Selesai' => 'ti-circle-check',
                default   => 'ti-refresh',
            };
            $color = match($s->status) {
                'Antrian' => 'amber',
                'Proses'  => 'blue',
                'Selesai' => 'green',
                default   => 'gray',
            };
            return [
                'plat'    => $s->kendaraan->plat_nomor ?? '-',
                'pemilik' => $s->kendaraan->nama_pemilik ?? '-',
                'mekanik' => $s->mekanik->nama_mekanik ?? '-',
                'label'   => $label,
                'status'  => $s->status,
                'icon'    => $icon,
                'color'   => $color,
                'time'    => $s->updated_at->diffForHumans(),
            ];
        });

    return response()->json($activities);
}
}
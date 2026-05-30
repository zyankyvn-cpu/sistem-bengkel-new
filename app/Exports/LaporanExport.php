<?php
namespace App\Exports;
 
use App\Models\Pembayaran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected Carbon $dari,
        protected Carbon $sampai,
        protected ?string $metode = null,
        protected ?string $status = null,
    ) {}
 
    public function collection()
    {
        return Pembayaran::with(['servis.kendaraan', 'servis.mekanik'])
            ->whereBetween('tanggal_bayar', [$this->dari->startOfDay(), $this->sampai->copy()->endOfDay()])
            ->when($this->metode, fn($q) => $q->where('metode_bayar', $this->metode))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderByDesc('tanggal_bayar')
            ->get();
    }
 
    public function headings(): array
    {
        return [
            'No', 'Kode Pembayaran', 'Tanggal Bayar',
            'Plat Nomor', 'Nama Pemilik', 'Mekanik',
            'Biaya Jasa', 'Biaya Sparepart', 'Total Bayar',
            'Jumlah Bayar', 'Kembalian',
            'Metode Bayar', 'Status', 'Catatan',
        ];
    }
 
    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->kode_pembayaran,
            Carbon::parse($row->tanggal_bayar)->format('d/m/Y H:i'),
            $row->servis->kendaraan->plat_nomor  ?? '-',
            $row->servis->kendaraan->nama_pemilik ?? '-',
            $row->servis->mekanik->nama_mekanik  ?? '-',
            $row->biaya_jasa,
            $row->total_biaya_jasa,
            $row->total_biaya_sparepart,
            $row->jumlah_bayar,
            $row->kembalian,
            $row->metode_bayar,
            $row->status,
            $row->catatan ?? '',
        ];
    }
 
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0F172A']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
 
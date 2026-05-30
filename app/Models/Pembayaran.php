<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'kode_pembayaran',
        'servis_id',
        'tanggal_bayar',
        'total_biaya_jasa',
        'total_biaya_sparepart',
        'total_bayar',
        'jumlah_bayar',
        'kembalian',
        'metode_bayar',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    const STATUS_LUNAS       = 'Lunas';
    const STATUS_BELUM_LUNAS = 'Belum Lunas';

    public static function daftarMetode(): array
    {
        return ['Tunai', 'Transfer', 'Debit'];
    }

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }

    public function getTotalBayarFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }

    public function getKembalianFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->kembalian, 0, ',', '.');
    }
}
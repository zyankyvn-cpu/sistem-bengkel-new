<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'sparepart';

    protected $fillable = [
        'kode_sparepart',
        'nama_sparepart',
        'kategori',
        'jenis_kendaraan',
        'merk',
        'stok',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
        'satuan',
        'keterangan',
    ];

    // Konstanta status stok
    const STATUS_STOK_AMAN    = 'aman';
    const STATUS_STOK_MENIPIS = 'menipis';
    const STATUS_STOK_HABIS   = 'habis';

    const JENIS_MOTOR  = 'Motor';
    const JENIS_MOBIL  = 'Mobil';
    const JENIS_SEMUA  = 'Semua';

    public static function daftarJenis(): array
    {
        return [
            self::JENIS_MOTOR => 'Motor',
            self::JENIS_MOBIL => 'Mobil',
            self::JENIS_SEMUA => 'Semua',
        ];
    }

    public static function daftarKategori(): array
    {
        return [
            'Oli & Pelumas',
            'Filter',
            'Rem',
            'Ban',
            'Aki',
            'Busi',
            'Lampu',
            'Body & Aksesoris',
            'Mesin',
            'Lainnya',
        ];
    }

    public static function daftarSatuan(): array
    {
        return ['pcs', 'liter', 'set', 'pasang', 'buah', 'botol'];
    }

    // Cek status stok
    public function getStatusStokAttribute(): string
    {
        if ($this->stok <= 0) {
            return self::STATUS_STOK_HABIS;
        } elseif ($this->stok <= $this->stok_minimum) {
            return self::STATUS_STOK_MENIPIS;
        }
        return self::STATUS_STOK_AMAN;
    }

    // Format harga jual
    public function getHargaJualFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    // Format harga beli
    public function getHargaBeliFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }
}